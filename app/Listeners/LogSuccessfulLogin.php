<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Services\Audit as AuditLogger;

class LogSuccessfulLogin implements ShouldQueue
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $logger = new AuditLogger();

        $payload = ["auth" => [
            "event" => "login",
            "id" => $event->user->id
        ]];

        $logger->recordEvent(
            'login',
            0,
            'Auth',
            $event->user->id,
            get_class($event->user),
            json_encode($payload)
        );
    }
}
