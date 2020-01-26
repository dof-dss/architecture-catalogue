<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Socialite;
use Carbon\Carbon;

use App\User;

use Exception;
use Illuminate\Database\QueryException;

use Illuminate\Support\Facades\Log;

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
            Log::error('handleProviderCallBack: ' . $e->getMessage());
            return redirect('/login')->withErrors(['Unable to sign in using GitHub']);
        }

        // if no name found then use the nickname
        if (!$user->name) {
            $user->name = $user->nickname;
        }

        try {
            $authUser = $this->findOrCreateUser($user);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                Log::info('handleProviderCallBack: ' . $e->getMessage());
                return redirect('/login')->withErrors(['A user already exists with this identity. Use another identity or create a new account.']);
            }
        }
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
        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => Carbon::now(),
            'provider_name' => 'GitHub',
            'provider_id' => $user->id
        ]);
        return $user;
    }
}
