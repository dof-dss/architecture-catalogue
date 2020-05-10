<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Services\Audit as AuditLogger;

class LogFailedLogin implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $logger = new AuditLogger();


        $payload = ["auth" => [
            "event" => "login failed",
            "id" => $event->user->id
        ]];

        $logger->recordEvent(
            'login failed',
            0,
            'Auth',
            $event->user->id,
            get_class($event->user),
            json_encode($payload)
        );
    }
}
