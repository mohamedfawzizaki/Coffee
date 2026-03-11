<?php

namespace App\Channels;

use App\Facades\Fcm;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class FcmChannel
{
    public function send($notifiable, Notification $notification)
    {
        if (!method_exists($notification, 'toFcm')) {
            return;
        }

        $data = $notification->toFcm($notifiable);

        if (!$data || !isset($data['to']) || empty($data['to'])) {
            Log::warning('FCM: No device token found for user ' . $notifiable->id);
            return;
        }

        try {
            $result = Fcm::send($data);
            Log::info('FCM: Notification sent successfullys', ['result' => $result]);
            return $result;
        } catch (\Exception $e) {
            Log::error('FCM: Failed to send notification', [
                'error' => $e->getMessage(),
                'user_id' => $notifiable->id,
                'data' => $data
            ]);

            // Don't throw exception to avoid stopping other notifications
            return false;
        }
    }
}
