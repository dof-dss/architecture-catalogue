<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PasswordReset;

class SendPasswordResetEmailTest extends TestCase
{
    use Notifiable;

    /**
     * Send welcome email using GOV.UK Notify.
     *
     * @return void
     */
    public function testSendPasswordResetEmail()
    {
        // stops notification being physically sent
        Notification::fake();

        $user = $this->loginAsFakeUser(false);
        $token = app('auth.password.broker')->createToken($user);
        $user->notify(new PasswordReset($user, $token));

        Notification::assertSentTo($user, PasswordReset::class);
    }
}
