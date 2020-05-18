<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use App\Events\AccountCreated;

use App\Services\Tracking as UsageTrackingClient;

// this event cannot be queued as it relies on the users identityToken

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
     * Determine if usage tracking is enabled.
     *
     * @return void
     */
    protected function usageTrackingEnabled()
    {
        return config('eausagetracking.enabled') == true;
    }

    /**
     * Determine if usage tracking is disabled.
     *
     * @return void
     */
    protected function usageTrackingDisabled()
    {
        return config('eausagetracking.enabled') == false;
    }

    /**
     * Handle the event.
     *
     * @param  AccountCreated  $event
     * @return void
     */
    public function handle(AccountCreated $event)
    {
        if ($this->usageTrackingDisabled()) {
            return;
        }

        // record a business event
        $tracker = new UsageTrackingClient();
        $tracker->recordEvent($event->user, (int) config('eausagetracking.account_created_event_id'));
    }
}
