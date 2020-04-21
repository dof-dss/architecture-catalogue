<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\AccountCreated;

use App\Services\Tracking as UsageTrackingClient;

class RecordUsageTrackingAccountCreatedEvent
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
     * @param  AccountCreated  $event
     * @return void
     */
    public function handle(AccountCreated $event)
    {
        // record a business event
        $tracker = new UsageTrackingClient();
        $tracker->recordEvent($event->user, (int) config('eausagetracking.account_created_event_id'));
    }
}
