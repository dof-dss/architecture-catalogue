<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// custom channel and message
use App\Channels\GovukNotifyChannel;
use App\Channels\Messages\GovukNotifyMessage;

class PasswordReset extends Notification
{
    use Queueable;

    protected $templateId;
    public $user;
    protected $token;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->templateId = config('govuknotify.password_reset_template_id');
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [GovukNotifyChannel::class];
    }

    /**
     * Get the GOV.UK Notify representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toGovukNotify($notifiable)
    {
        $params = [
            'action_url' => url(
                config('app.url') . route(
                    'password.reset',
                    [
                        'token' => $this->token,
                        'email' => $this->user->email
                    ],
                    false
                )
            ),
            'count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'),
        ];
        return (new GovukNotifyMessage)
            ->to($this->user->email)
            ->templateId($this->templateId)
            ->params($params);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
