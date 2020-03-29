<?php

namespace App\Services;

// http driver
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException as RequestException;

use Exception;
use App\Exceptions\AuthException;

// used to debug Guzzle
use App\Services\GuzzleLogger;

class Authorisation
{
    /**
    *--------------------------------------------------------------------------
    * Authorisation class
    *--------------------------------------------------------------------------
    *
    * This class is used to obtain tokens for API authorisation
    *
    * @package    architecture-cataloge
    * @author     Stephen Patterson <stephen.patterson@finance-ni.gov.uk>
    */

    /**
     * Generate a an authorisation token from Amazon Cognito.
     *
     * @return string
     * @throws AuditException if call to API fails
     */
    public function getAuthorisationToken()
    {
        $credentials = base64_encode(config('eaaudit.cognito_user') . ':' . config('eaaudit.cognito_password'));
        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Authorization' => 'Basic ' . $credentials
        ];
        $parameters = [
            'base_uri' => config('eaaudit.cognito_url'),
            'headers' => $headers
        ];
        $logger = new GuzzleLogger;
        $parameters = $logger->injectLogger($parameters);
        $authorisationClient = new GuzzleClient($parameters);

        $url = 'oauth2/token?grant_type=client_credentials';
        try {
            $response = $authorisationClient->post($url);
        } catch (Exception $e) {
            throw new AuthException($e);
        }
        $data = json_decode($response->getBody());
        return $data->access_token;
    }


    /**
     * Inject authorisation token into headers.
     *
     * @param array $headers
     * @return array
     */
    public function injectAuthorisationToken($headers)
    {
        $token = $this->getAuthorisationToken();
        $headers += ['Authorization' => 'Bearer ' . $token];
        return $headers;
    }
}
