<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// custom channel and message
use App\Channels\GovukNotifyChannel;
use App\Channels\Messages\GovukNotifyMessage;

use Illuminate\Notifications\Messages\SlackMessage;

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
        return [GovukNotifyChannel::class, 'slack'];
    }

    /**
     * Get the GOV.UK Notify representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \App\Messages\GovukNotifyMessage
     */
    public function toGovukNotify($notifiable)
    {
        return (new GovukNotifyMessage)
            ->to($this->user->email)
            ->templateId($this->templateId);
    }

    /**
     * Get the Slack representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return
     */
    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->from('Architecture Catalogue')
            ->to('#application_support_test')
            ->content($this->user->email . ' has created an account.');
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
