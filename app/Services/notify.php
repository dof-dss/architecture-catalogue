<?php

namespace App\Services;

use Alphagov\Notifications\Client as NotifyClient;
use Http\Adapter\Guzzle6\Client as GuzzleClient;

class Notify
{
    /*
    |--------------------------------------------------------------------------
    | Notify class
    |--------------------------------------------------------------------------
    |
    | This class is used to abstract away some of the detail required to use
    | the GOV.UK Notify service
    |
    */

    private $notifyClient;

    public function __construct()
    {
        $this->notifyClient = new NotifyClient([
            'apiKey' => config('govuknotify.govuk_notify_apikey'),
            'httpClient' => new GuzzleClient
        ]);
    }

    public function sendEmailUsingGovukNotify($emailAddress, $templateId, $params = [])
    {
        try {
            $response = $this->notifyClient->sendEmail(
                $emailAddress,
                $templateId,
                $params
            );
        } catch (NotifyException $e) {
            // do something
        };
    }

    public function sendSMSUsingGovukNotify(String $sName)
    {
        return 'Sending SMS to ' . $sName . ' using GOV.UK Notify message';
    }
}
