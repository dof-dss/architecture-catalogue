<?php

namespace App\Observers;

use App\User;
use App\Services\Notify as NotifyClient;

class UserObserver
{
    // welecome email template id
    protected $templateId = '44ef4346-37da-4733-b6f0-12e0f4c768f9';

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
          $this->templateId
      );
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
}
