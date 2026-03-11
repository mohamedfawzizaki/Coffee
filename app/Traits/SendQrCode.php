<?php

namespace App\Traits;
use Pusher\Pusher;
use Illuminate\Support\Facades\Log;

trait SendQrCode
{
    public function sendQrCode($qrCode, $branchId, $totalPrice)
    {

        $options = array(
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'encrypted' => true
            );

        $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );

        $data = ['qr_link' => $qrCode, 'branch_id' => $branchId, 'total_price' => $totalPrice];

        $notify = 'my-channel';

        try {

        $pusher->trigger($notify, 'App\\Events\\FlutterEvent', $data);


        return true;

    } catch (\Throwable $th) {

        Log::error('Pusher Error: ' . $th->getMessage());

        return $th;


    }
    }
}
