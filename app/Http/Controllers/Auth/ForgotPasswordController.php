<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;


use Illuminate\Http\Request;
use App\Services\Notify as NotifyClient;

use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $credentials = $this->credentials($request);
        $repository = $this->broker()->getRepository();
        $user = $this->broker()->getUser($credentials);

        $response = null;

        // check for valid user
        if (is_null($user)) {
            $response = Password::INVALID_USER;
            return $this->sendResetLinkFailedResponse($request, $response);
        }

        //  check for throttling
        if (method_exists($repository, 'recentlyCreatedToken')
            &&
            ($repository->recentlyCreatedToken($user))
            ) {
            $response = 'passwords.throttled';
            return $this->sendResetLinkFailedResponse($request, $response);
        }

        $this->sendEmailUsingGovukNotify($user->email, $repository->create($user));
        $response = Password::RESET_LINK_SENT;
        return $this->sendResetLinkResponse($request, $response);
    }

    /**
     * Ovverride the trait to use GOV.UK Notify to send the password reset link
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendEmailUsingGovukNotify($email, $token)
    {
        // send a reset password email to the user (ideally this should be a queued job)
        $notifyClient = new NotifyClient();
        $params = [
            'action_url' => url(
                config('app.url') . route(
                    'password.reset',
                    [
                        'token' => $token,
                        'email' => $email
                    ],
                    false
                )
            )
        ];
        $notifyClient->sendEmailUsingGovukNotify(
            $email,
            config('govuknotify.password_reset_template_id'),
            $params
        );
    }
}
