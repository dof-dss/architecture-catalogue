<?php

namespace App\Services;

// http driver
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException as RequestException;

//  models
use App\User;

// used to generate GUID
use Illuminate\Support\Str;

use Exception;
// specific exception handler
use App\Exceptions\AuditException;

use Illuminate\Support\Facades\Log;

class Audit
{
    /**
    *--------------------------------------------------------------------------
    * Audit class
    *--------------------------------------------------------------------------
    *
    * This class is used to abstract away some of the detail required to use
    * the NICS EA Audit Service
    *
    * @package    architecture-cataloge
    * @author     Stephen Patterson <stephen.patterson@finance-ni.gov.uk>
    */


    /**
     * Build up a GuzzleHttp client to use the NICS EA Usage Tracking API.
     *
     */
    public function __construct()
    {
        $this->client = new GuzzleClient([
            'base_uri' => config('eaaudit.api')
        ]);
    }

    /**
     * Records a transaction using the NICS EA Audit Service API.
     *
     * @param string $description (type of event to be audited e.g. created, update, deleted)
     * @param integer $subject_id (primary key of entity being audited)
     * @param string $subject_type (model or table name of entity being audited)
     * @param integer $causer_id (primary key e.g. user_id)
     * @param string $causer_type (model or table name e.g. users)
     * @param string $details (payload to be stored)
     * @return array
     * @throws AuditException if call to API fails
     */
    public function recordEvent(
        $description,
        $subject_id,
        $subject_type,
        $causer_id,
        $causer_type,
        $details
    ) {
        // invoke the API
        $url = 'audits';
        $headers = [
            'Content-Type' => 'application/json',
            'x-requestid' => $this->getUuid()
        ];
        $params = [
            'subjectId' => $subject_id,
            'subject' => $subject_type,
            'actorId' => $causer_id,
            'actor' => $causer_type,
            'description' => $description,
            'properties' => $details
        ];
        try {
            $result = $this->client->post($url, [
                'headers' => $headers,
                'json' => $params
            ]);
        } catch (Exception $e) {
            throw new AuditException($e);
        }
    }

    /**
     * Generate a UUID.
     *
     * @return string
     */
    private function getUuid()
    {
        return str::uuid()->toString();
    }
}
