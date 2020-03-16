<?php

namespace App\Observers;

use App\User;
use App\Services\Notify as NotifyClient;
use App\Services\Tracking as UsageTrackingClient;

// used to generate GUID
use Illuminate\Support\Str;

class UserObserver
{

    /**
     * Handle the user "creating" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        // generate the uuid
        $user->uuid = $this->getUuid();
    }

    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        // send a welcome email to the user (ideally this should be a queued job)
        $notifyClient = new NotifyClient();
        $notifyClient->sendEmailUsingGovukNotify(
            $user->email,
            config('govuknotify.user_welcome_template_id')
        );
        // record a business event
        $tracker = new UsageTrackingClient();
        $tracker->recordEvent($user, (int) config('eausagetracking.account_created_event_id'));
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

    /**
     * Generate a UUID.
     *
     * @return string
     */
    private function getUuid()
    {
        return str::uuid()->toString();
    }
}
