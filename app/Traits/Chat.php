<?php

namespace App\Traits;

use Pusher\Pusher;

trait Chat
{

    public function sendmessage($reciever, $message, $from , $type){


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

        $data = ['to' => $reciever,   'message' => $message, 'from' => $from, 'type' => $type];

        $notify = 'my-channel';

        try {

        $pusher->trigger($notify, 'App\\Events\\FlutterEvent', $data);


        return true;

    } catch (\Throwable $th) {

        return $th;
    }

    }


    public function sendnotification($reciever, $message, $data){

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

        $data = ['to' => $reciever,   'type' => $message, 'data' => $data];

        $notify = 'my-channel';

        try {

        $pusher->trigger($notify, 'App\\Events\\FlutterEvent', $data);

        return true;

    } catch (\Throwable $th) {

        return $th;
    }

    }

}


