<?php

namespace App\Observers;

use App\User;

use App\Notifications\AccountCreated as AccountCreatedNotification;

use App\Events\AccountCreated as AccountCreatedEvent;

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
        $user->uuid = $user->getUuid();
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
        $user->notify(new AccountCreatedNotification($user));

        // record the account creation as an event with the Usage Tracking service
        event(new AccountCreatedEvent($user));
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
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
}
