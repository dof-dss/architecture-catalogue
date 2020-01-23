<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Socialite;
use Carbon\Carbon;

use App\User;

use Illuminate\Database\QueryException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('github')->user();
        } catch (Exception $e) {
            return redirect::to('/login')->withErrors(['msg', 'Unable to sign in using GitHub']);
        }

        // check that the user does not already exist - this is WRONG
        if (!User::where('email', $user->email)->where('provider_id', '!=', $user->id)) {
            return redirect('/login')->withErrors(['Login', 'A user with this ']);
        }

        // if no name found then use the nickname
        if (!$user->name) {
            $user->name = $user->nickname;
        }

        $authUser = $this->findOrCreateUser($user);

        Auth::login($authUser, true);

        return redirect($this->redirectTo);
    }

    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $guser
     * @return User
     */
    private function findOrCreateUser($user)
    {
        if ($authUser = User::where('provider_id', $user->id)->where('provider_name', 'GitHub')->first()) {
            return $authUser;
        }

        // we may collide with an existing email address
        try {
            $user = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => Carbon::now(),
                'provider_name' => 'GitHub',
                'provider_id' => $user->id
            ]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                abort(403, 'A user already exists with this identity');
            };
        }

        return $user;
    }
}
