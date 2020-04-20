<?php

namespace App\Services;

// http driver
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException as RequestException;

//  models
use App\User;

// used to debug Guzzle
use App\Services\GuzzleLogger;

use Illuminate\Support\Facades\Log;

use App\Services\Authorisation as AuthService;

class Tracking
{
    /**
    *--------------------------------------------------------------------------
    * Tracking class
    *--------------------------------------------------------------------------
    *
    * This class is used to abstract away some of the detail required to use
    * the NICS EA Usage Tracking Service
    *
    * @package    architecture-cataloge
    * @author     Stephen Patterson <stephen.patterson@finance-ni.gov.uk>
    */

    private $client;
    private $tenantId;
    private $authService;

    /**
     * Build up a GuzzleHttp client to use the NICS EA Usage Tracking API.
     *
     */
    public function __construct()
    {
        $this->tenantId = config('eausagetracking.tenant_id');
        $this->authService = new AuthService;
        $headers = [
            'tenantId' => $this->tenantId,
            'Content-Type' => 'application/json'
        ];
        $headers = $this->authService->injectAuthorisationToken($headers);
        $parameters = [
            'base_uri' => config('eausagetracking.api'),
            'headers' => $headers
        ];
        $logger = new GuzzleLogger;
        $parameters = $logger->injectLogger($parameters);
        $this->client = new GuzzleClient($parameters);
    }

    /**
     * Records an application business event using the NICS EA Usage Tracking API.
     *
     * @param App\User $user
     * @param integer $eventId
     * @return array
     * @throws Exception if call to API fails
     */
    public function recordEvent($user, $eventId)
    {
        // if we logged in using AWS Cognito we will have a user token
        // otherwise we will need to create a tracking service user
        if (session('id_token')) {
            $identityToken = session('id_token');
        } else {
            $trackingUser = $this->findOrCreateUser($user);
            $identityToken = $user->uuid;
        }

        // invoke the API
        $url = 'ApplicationUsage';
        $params = [
            'applicationEventId' => $eventId,
            'identityToken' => $identityToken
        ];
        try {
            $result = $this->client->post($url, [
                'json' => $params
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $status = $e->getResponse()->getStatusCode();
                $message = $e->getResponse()->getReasonPhrase();
                abort($status, $message);
            }
        }
        return (['status' => $result->getStatusCode()]);
    }

    /**
     * Find or create an NICS Usage Tracking Service user based on the
     * currently logged in user.
     *
     * @param App\User $user
     * @return object
     * @throws Exception if call to API fails
     */
    private function findOrCreateUser(User $user)
    {
        // try to find the current user
        $url = 'ApplicationUser/Details?id=' . $user->uuid;
        try {
            $result = $this->client->get($url);
        } catch (RequestException $e) {
            $status = $e->getResponse()->getStatusCode();
            if ($status == 404) {
                return $this->createUser($user);
            } else {
                $message = $e->getResponse()->getReasonPhrase();
                abort($status, $message);
            }
        }
        return $result->getBody();
    }

    /**
     * Create an NICS Usage Tracking Service user based on the
     * currently logged in user.
     *
     * @param App\User $user
     * @return object
     * @throws Exception if call to API fails
     */
    private function createUser($user)
    {
        $url = 'ApplicationUser';
        $params = [
            'id' => $user->uuid,
            'name' => $user->name
        ];
        try {
            $result = $this->client->post($url, [
                'json' => $params
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $status = $e->getResponse()->getStatusCode();
                $message = $e->getResponse()->getReasonPhrase();
                abort($status, $message);
            }
        }
        return $result->getBody();
    }
}
