<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    // pass in a parameter for a specific message
    public function report($errorMessage = "Unhandled authorisation exception")
    {
        // log the exeption in the application log
        Log::alert($errorMessage . '. Authorisation service (AWS Cognito): ' . $this->getCustomMessage());
    }

    public function render($request)
    {
        //
    }

    public function getCustomMessage()
    {
        return $this->getMessage();
    }
}
