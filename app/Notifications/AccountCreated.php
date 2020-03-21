<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// custom channel and message
use App\Channels\GovukNotifyChannel;
use App\Channels\Messages\GovukNotifyMessage;

class AccountCreated extends Notification
{
    use Queueable;

    protected $templateId;
    public $user;

    /**
     * Create a new notification instance.
     *
     * @param $user
     * @return void
     */
    public function __construct($user)
    {
        $this->templateId = config('govuknotify.user_welcome_template_id');
        $this->user = $user;
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
        return (new GovukNotifyMessage)
            ->to($this->user->email)
            ->templateId($this->templateId);
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
