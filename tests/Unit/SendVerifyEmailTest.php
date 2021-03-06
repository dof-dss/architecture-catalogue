<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VerifyEmail;

class SendVerifyEmailTest extends TestCase
{
    use Notifiable;

    /**
     * Send welcome email using GOV.UK Notify.
     *
     * @return void
     */
    public function testSendVerifyEmail()
    {
        // stops notification being physically sent
        Notification::fake();

        $user = $this->loginAsFakeUser(false);
        $user->notify(new VerifyEmail($user));

        Notification::assertSentTo($user, VerifyEmail::class);
    }
}
