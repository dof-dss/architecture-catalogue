<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Support\Facades\Log;

class GovukNotifyException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    // pass in a parameter for a specific message
    public function report($errorMessage = "Unhandled GOV.UK Notify exception")
    {
        // log the exeption in the application log
        Log::alert($errorMessage . '. GOVU.UK Notify service: ' . $this->getCustomMessage());
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
