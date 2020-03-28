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
    public function report($errorMessage = "Notification failure - unable to send notification")
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
