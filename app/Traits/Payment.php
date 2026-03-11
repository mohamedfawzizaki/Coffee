<?php


namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use CodeBugLab\NoonPayment\NoonPayment;
use Illuminate\Support\Str;

trait Payment {

    /**
     * Process payment using Noon Payment
     *
     * @param float $price
     * @param object $user
     * @param string $reference Optional order reference
     * @param string $orderName Optional order name
     * @return array
     */
    public function payment($amount, $user, $payment_id)
    {

        try{

            $splitName = explode(' ', $user->name, 2);

            $first_name = $splitName[0];

            $last_name = !empty($splitName[1]) ? $splitName[1] : $first_name;

            $reference = uniqid();

            $amount = $amount * 100;

            $postData = [
                "amount" => $amount,
                "currency" => "SAR",
                "payment_methods" => [
                    15949,
                ],

                "notifications_url" => env("PAYMOB_REDIRECT_URL") . '?reference=' . $payment_id,
                "redirection_url"   => env("PAYMOB_REDIRECT_URL") . '?reference=' . $payment_id,
                "items" => [
                    [
                        "name" => "Item name 1",
                        "amount" => $amount,
                        "description" => "Watch",
                        "quantity" => 1
                    ]
                ],
                "billing_data" => [
                    "apartment" => "6",
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "street" => "938, Al-Jadeed Bldg",
                    "building" => "939",
                    "phone_number" => $user->phone,
                    "country" => "SA",
                    "email" => $user->email,
                    "floor" => "1",
                    "state" => "Alkhuwair"
                ],
                "special_reference" => $reference,
                "customer" => [
                    "first_name" => $first_name,
                    "last_name" => $last_name,
                    "email" => $user->email,
                    "extras" => [
                        "re" => "22"
                    ]
                ],
                "extras" => [
                    "ee" => 22
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Token ' . env('PAYMOB_SECRET_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://ksa.paymob.com/v1/intention/', $postData);

             $responseData = $response->json();

            //  return $responseData;

            $client_secret =  $responseData['client_secret'];

            $url = "https://ksa.paymob.com/unifiedcheckout/?publicKey=" . env('PAYMOB_PUBLIC_KEY') . "&clientSecret=" . $client_secret;

            return [
                'status'      => true,
                'payment_url' => $url,
                'message'     => null,

            ];

        } catch (\Exception $e) {
            return [
                'status'      => false,
                'payment_url' => null,
                'message'     => 'Payment processing error: ' . $e->getMessage()
            ];
        }
    }

}
