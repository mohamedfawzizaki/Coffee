<?php


namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Propaganistas\LaravelPhone\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;

trait SendSms {


    protected function resolveSmsLocale(?string $locale = null): ?string
    {
        $locale = $locale ?: (function () {
            try {
                $header = request()?->header('Accept-Language');
                if (is_string($header) && $header !== '') {
                    // ex: "ar-SA,ar;q=0.9,en;q=0.8"
                    return substr(trim($header), 0, 2);
                }
            } catch (\Throwable $e) {
                // ignore
            }

            return app()->getLocale();
        })();

        if (!is_string($locale) || $locale === '') {
            return null;
        }

        return strtolower(substr($locale, 0, 2));
    }

    protected function buildVerificationMessage(string $otp, ?string $locale = null): string
    {
        $ar = 'رمز التحقق الخاص بك هو: ' . $otp . ' يرجى استخدامه لتسجيل الدخول في تطبيق كوفيماتكس وعدم مشاركته مع اي شخص.';
        $en = 'Your verification code is ' . $otp . '. Please use it to log in to the Coffematics app and do not share it with anyone.';

        $locale = $this->resolveSmsLocale($locale);

        if ($locale === 'ar') {
            return $ar;
        }

        if ($locale === 'en') {
            return $en;
        }

        // Fallback: send both if locale is unknown
        return $ar . "\n" . $en;
    }

    public function sendWhatsAppMessage($phone, $otp, ?string $locale = null)
    {
        try {

            $otp = (string) $otp;
            $message = $this->buildVerificationMessage($otp, $locale);

            $phoneUtil = PhoneNumberUtil::getInstance();

            $numberProto = $phoneUtil->parse($phone, 'SA');

            $formattedPhone = $phoneUtil->format($numberProto, PhoneNumberFormat::E164);

            $params=array(
            'token' => 'kyxfuohg9k3n7ktn',
            'to'    => $formattedPhone,
            'body'  => $message
            );

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.ultramsg.com/instance123024/messages/chat",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded"
            ),
            ));

            $response = curl_exec($curl);

            $err = curl_error($curl);

            curl_close($curl);

            return $response;

            // if ($err) {
            // echo "cURL Error #:" . $err;
            // } else {
            // echo $response;
            // }

      } catch (\Exception $e) {

        return $e->getMessage();

    }

  }


}