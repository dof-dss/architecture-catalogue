<?php

namespace App\Exceptions;

use Exception;

use Illuminate\Support\Facades\Log;

class AuthException extends Exception
{
    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report($errorMessage = "Authorisation failure - unable to get authorisation token")
    {
        Log::alert($errorMessage, [
            'class' => self::class,
            'message' => $this->getShortMessage(),
            'stack trace' => self::getTrace()
        ]);
    }

    public function render($request)
    {
        //
    }

    public function getShortMessage()
    {
        // grab the first 2 lines of the message
        $lines = explode("\n", self::getMessage());
        return $lines[0] . $lines[1];
    }
}
