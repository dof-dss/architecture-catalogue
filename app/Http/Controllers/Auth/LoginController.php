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
     * Redirect the user to the provider's authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        if ($provider == 'microsoft') {
            // convert provider name to use custom Azure driver
            $provider = 'azure';
        }
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        if ($provider == 'microsoft') {
            // convert provider name to use custom Azure driver
            $provider = 'azure';
        }
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            Log::error('handleProviderCallBack: ' . $e->getMessage());
            // return redirect('/login')->withErrors(['Unable to sign in: ' . $e->getMessage()]);
            return redirect('/login')->withErrors(['Unable to sign in using ' . $provider]);
        }

        // store the tokens for future use with the usage tracking service
        session(['access_token' => $user->token]);
        session(['refresh_token' => $user->refreshToken]);
        session(['expires_in' => $user->expiresIn]);
        // *** Cognito provider only ***
        session(['id_token' => $user->idToken]);

        // if no name found then use the nickname
        if (!$user->name) {
            $user->name = $user->nickname;
        }

        try {
            $authUser = $this->findOrCreateUser($user, $provider);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                Log::info('handleProviderCallBack: ' . $e->getMessage());
                return redirect('/login')->withErrors([
                  'A user already exists with this identity. Use another identity or create a new account.'
                ]);
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
    private function findOrCreateUser($user, $provider)
    {
        if ($authUser = User::where('provider_id', $user->id)->where('provider_name', $provider)->first()) {
            return $authUser;
        }

        // we may collide with an existing email address
        $user = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => Carbon::now(),
            'provider_name' => $provider,
            'provider_id' => $user->id
        ]);
        return $user;
    }
}
