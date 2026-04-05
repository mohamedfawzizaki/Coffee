<?php

namespace App\Notifications\Branch;

use App\Channels\FcmChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class BranchStatusNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $branch;

    /**
     * Create a new notification instance.
     */
    public function __construct($branch)
    {
        $this->branch = $branch;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', FcmChannel::class];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusText = $this->branch->status ? __('Active') : __('Inactive');
        return [
            'title' => __('Branch Status Updated'),
            'body'  => __('Branch :name is now :status', ['name' => $this->branch->title, 'status' => $statusText]),
            'branch_id' => $this->branch->id,
            'status' => $this->branch->status,
        ];
    }

    public function toFcm($notifiable)
    {
        $statusText = $this->branch->status ? __('Active') : __('Inactive');
        return [
            'to' => $notifiable->device_token,
            'notification' => [
                'title' => __('Branch Status Updated'),
                'body'  => __('Branch :name is now :status', ['name' => $this->branch->title, 'status' => $statusText]),
            ],
            'data' => [
                'type' => 'branch_status_updated',
                'branch_id' => (string) $this->branch->id,
                'status' => (string) $this->branch->status,
            ],
        ];
    }
}
