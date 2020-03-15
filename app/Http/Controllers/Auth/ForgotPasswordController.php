<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;
use App\Services\Notify as NotifyClient;

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

    // reset password email template id
    protected $templateId = 'd0e7b9a7-241a-4730-af40-383ea66bf132';


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
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
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
            'action_url' => route('password.reset') . '/' . $token
        ];
        $notifyClient->sendEmailUsingGovukNotify(
            $request->email,
            $this->templateId,
            $params
        );
    }
}
