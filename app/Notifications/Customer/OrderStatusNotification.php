<?php

namespace App\Notifications\Customer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public $order;
    public $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($order, $status)
    {
        $this->order  = $order;
        $this->status = $status;
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

    public function toArray(object $notifiable): array
    {
        $statusKey = $this->getStatusKey($this->status);
        $statusTranslated = __($statusKey);
        
        return [
            'title'    => __('Order Status Updated'),
            'body'     => __('Your order status has been updated to :status', ['status' => $statusTranslated]),
            'order_id' => $this->order->id,
            'status'   => $this->status,
        ];
    }

    public function toFcm($notifiable)
    {
        $statusKey = $this->getStatusKey($this->status);
        $statusTranslated = __($statusKey);

        return [
            'to'           => $notifiable->device_token,
            'notification' => [
                'title'    => __('Order Status Updated'),
                'body'     => __('Your order status has been updated to :status', ['status' => $statusTranslated]),
            ],
            'data'         => [
                'order_id' => (string) $this->order->id,
                'status'   => $this->status,
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
            ],
        ];
    }

    protected function getStatusKey($status)
    {
        $map = [
            'pending'    => 'Pending',
            'processing' => 'Preparing',
            'ready'      => 'Ready for Pickup',
            'completed'  => 'Completed',
            'cancelled'  => 'Cancelled',
        ];

        return $map[$status] ?? ucfirst($status);
    }
}
