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
        // *** change to custom config ***
        if (config('app.env') == 'local' ||
              config('app.env') == 'testing' ||
              config('app.env') == 'sandbox') {
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
