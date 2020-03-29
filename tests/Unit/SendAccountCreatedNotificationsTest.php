<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AccountCreated;

class SendAccountCreatedNotificationsTest extends TestCase
{
    use Notifiable;

    /**
     * Send welcome email using GOV.UK Notify.
     *
     * @return void
     */
    public function testSendWelcomeEmail()
    {
        // stops notification being physically sent
        Notification::fake();

        $user = $this->loginAsFakeUser(false);
        $user->notify(new AccountCreated($user));

        Notification::assertSentTo($user, AccountCreated::class);
    }
}
