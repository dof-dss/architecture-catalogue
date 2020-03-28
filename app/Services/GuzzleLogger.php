<?php

namespace App\Services;

// used to debug Guzzle
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;

class GuzzleLogger
{
    /**
    *--------------------------------------------------------------------------
    * GuzzleLogger class
    *--------------------------------------------------------------------------
    *
    * This class is used to help debug GuzzleClient
    *
    * @package    architecture-cataloge
    * @author     Stephen Patterson <stephen.patterson@finance-ni.gov.uk>
    */

    public const DEBUG = "\n>>>>>>>>\n{request}\n<<<<<<<<\n{response}";
    /**
     * Build a stack to log Guzzle http requests and responses
     *
     * @param array $params
     * @return array
     * @throws AuditException if call to API fails
     */
    public function injectLogger($params)
    {
        // debug HTTP traffic if in local development environment only
        if (config('app.env') == 'local') {
            $stack = HandlerStack::create();
            $logChannel = app()->get('log')->channel('stack');
            $stack->push(
                Middleware::log(
                    $logChannel,
                    new MessageFormatter(self::DEBUG)
                )
            );
            $params += ['handler' => $stack];
        }
        return $params;
    }
}
