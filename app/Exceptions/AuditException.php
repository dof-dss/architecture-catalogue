<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Support\Facades\Log;

class AuditException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    // pass in a parameter for a specific message???
    public function report($errorMessage = "Unhandled audit exception")
    {
        // log the exeption in the application log
        Log::error($errorMessage . '. NICS Audit Service: ' . $this->getCustomMessage());
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
