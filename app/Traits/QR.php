<?php

namespace App\Traits;

use Illuminate\Support\Facades\Crypt;
use QrCode;
use Illuminate\Support\Str;

trait QR
{
    public function createQr($data, $type, $folder = 'qrcode/'){

        $random      = Str::random(15) . time();

        // $crepted     = Crypt::encrypt($data);

        $elementName = substr($data, 0, 10);

        $elementName = $elementName . $random . '.svg';

        $path        = public_path($folder .  $elementName);

        $qrData = $type . ',' . $data;

        QrCode::format('svg')->generate($qrData,  $path);

        $path = asset($folder .  $elementName);

        return $path;
    }




}
