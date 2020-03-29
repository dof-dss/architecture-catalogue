<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

use Alphagov\Notifications\Client as NotifyClient;
use Http\Adapter\Guzzle6\Client as GuzzleClient;

use Exception;
use App\Exceptions\GovukNotifyException;

class GovukNotifyChannel
{
    private $notifyClient;

    public function __construct()
    {
        $this->notifyClient = new NotifyClient([
            'apiKey' => config('govuknotify.govuk_notify_apikey'),
            'httpClient' => new GuzzleClient
        ]);
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toGovukNotify($notifiable);

        $this->sendEmailUsingGovukNotify(
            $message->to,
            $message->templateId,
            $message->params
        );
    }

    /**
     * Send an email using GOV.UK Notify.
     *
     * @param   string  $emailAddress
     * @param   string  $templateId
     * @param   array  $params
     * @throws  GovukNotifyException

     * @return  void
     */
    private function sendEmailUsingGovukNotify($emailAddress, $templateId, $params = [])
    {
        try {
            $response = $this->notifyClient->sendEmail(
                $emailAddress,
                $templateId,
                $params
            );
        } catch (Exception $ex) {
            throw GovukNotifyException($ex);
        }
    }
}
