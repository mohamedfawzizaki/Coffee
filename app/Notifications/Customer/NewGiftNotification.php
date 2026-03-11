<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewGiftNotification extends Notification
{
    use Queueable;

    protected $title;

    protected $sender;


    /**
     * Create a new notification instance.
     */
    public function __construct($title, $sender)
    {
        $this->title = $title;
        $this->sender = $sender;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', \App\Channels\FcmChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title'     => __('New Gift'),
            'message'   => __('You have received a new gift from :name', ['name' => $this->sender?->name ?? '']) ?? '',

        ];
    }

    public function toFcm($notifiable)
    {
        return [
            'to' => $notifiable->device_token,
            'notification' => [
                'title'    => __('New Gift'),
                'body'     => __('You have received a new gift from :name', ['name' => $this->sender?->name ?? '']) ?? '',
            ],
        ];
    }
}
