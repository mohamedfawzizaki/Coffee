<?php

namespace App\Service\Foodics;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPoint;
use App\Models\Customer\UnregisteredCustomer;
use App\Models\CustomerCard\CustomerCard;
use App\Models\Foodics\BannedNumber;
use App\Models\Foodics\Foodics;
use App\Traits\QR;
use App\Traits\SendQrCode;
use Illuminate\Support\Facades\Log;

class WebHookService
{
    use QR, SendQrCode;

    public function createWebHookOrder($response)
    {
        try {
            $webhookData = json_decode($response, true);

            // Validate received webhook data
            if (!$webhookData || !isset($webhookData['order'])) {
                Log::channel('webhook_error')->error('Invalid webhook data: Missing order data', [
                    'response' => $response
                ]);
                return true;
            }

            $order = $webhookData['order'];

            $event = $webhookData['event'];

            // Check for required order fields
            if (!isset($order['id']) || !isset($order['reference'])) {
                Log::channel('webhook_error')->error('Invalid webhook data: Missing required order fields', [
                    'order_data' => $order
                ]);
                return true;
            }

            // Process customer data
            if (isset($order['customer']['phone'])) {

                    $this->handleCustomer($order['customer']['phone'], $order['total_price'] ?? 0, $order['id'], $event);

            }

            return true;

        } catch (\Throwable $th) {
            Log::channel('webhook_error')->error('Foodics WebHook Error: ' . $th->getMessage() . ' | Line: ' . $th->getLine() . ' | File: ' . $th->getFile(), [
                'trace' => $th->getTraceAsString(),
                'response' => $response
            ]);
            return true;
        }
    }

    public function handleCustomer($customerPhone, $totalPrice, $orderId = null, $event)
    {
        try {
            $existsBannedNumber = BannedNumber::where('number', $customerPhone)->first();

            if($existsBannedNumber){
                return true;
            }

            $existingCustomer = Customer::where('phone', $customerPhone)->first();

            if($existingCustomer){


                $this->addPointsToCustomer($existingCustomer, $totalPrice, $orderId, $event);

            } else {

                $this->createUnregisteredCustomer($customerPhone, $totalPrice);

            }

            return true;

        } catch (\Throwable $th) {
            Log::channel('webhook_error')->error('Error in handleCustomer: ' . $th->getMessage() . ' | Line: ' . $th->getLine() . ' | File: ' . $th->getFile(), [
                'phone' => $customerPhone,
                'total_price' => $totalPrice,
                'trace' => $th->getTraceAsString()
            ]);
            return true;
        }
    }



    public function addPointsToCustomer($existingCustomer, $totalPrice, $orderId = null, $event)
    {
        try {

            if(isset($event) && $event == 'order.updated'){

                $points = customerMoneyToPoint($existingCustomer->id, $totalPrice);

                $customerPoint = CustomerPoint::where('customer_id', $existingCustomer->id)->where('order_id', $orderId)->first();

                if($customerPoint){

                    $oldPoints = $customerPoint->amount;

                    if($points > 0){
                        $customerPoint->update([
                            'amount' => round($points),
                        ]);
                    }else{
                        $customerPoint->delete();
                    }
                }

            }else{


            $existingCustomer->update([
                'points' => $existingCustomer->points + $totalPrice,
            ]);

            $points = customerMoneyToPoint($existingCustomer->id, $totalPrice);


            CustomerPoint::create([
                'customer_id' => $existingCustomer->id,
                'order_id'    => $orderId,
                'amount'      => round($points),
                'ar_content'  => 'تم إضافة النقاط من الطلب الفوديكس',
                'en_content'  => 'Points Added From Foodics Order',
                'type'        => 'in',
            ]);

            }


            return true;

        } catch (\Throwable $th) {

            Log::channel('webhook_error')->error('Error in addPointsToCustomer: ' . $th->getMessage() . ' | Line: ' . $th->getLine() . ' | File: ' . $th->getFile(), [
                'customer_id' => $existingCustomer->id ?? null,
                'phone' => $existingCustomer->phone ?? null,
                'total_price' => $totalPrice,
                'trace' => $th->getTraceAsString()
            ]);

            return true;
        }
    }


    public function createUnregisteredCustomer($customerPhone, $totalPrice)
    {
        try {

            $existingUnregisteredCustomer = UnregisteredCustomer::where('phone', $customerPhone)->first();

            $points = 0;

            $card = CustomerCard::first();

            if(!$card){
                return true;
            }

            $points = round($totalPrice / $card->money_to_point);


            if($existingUnregisteredCustomer){

                $existingUnregisteredCustomer->update([
                    'points' => $existingUnregisteredCustomer->points + $points,
                    'orders' => $existingUnregisteredCustomer->orders + 1,
                    'total_spent' => $existingUnregisteredCustomer->total_spent + $totalPrice,
                ]);

            } else {

                UnregisteredCustomer::create([
                    'phone' => $customerPhone,
                    'points' => $points,
                    'orders' => 1,
                    'total_spent' => $totalPrice,
                ]);
            }

            return true;

        } catch (\Throwable $th) {
            Log::channel('webhook_error')->error('Error in createUnregisteredCustomer: ' . $th->getMessage() . ' | Line: ' . $th->getLine() . ' | File: ' . $th->getFile(), [
                'phone' => $customerPhone,
                'total_price' => $totalPrice,
                'trace' => $th->getTraceAsString()
            ]);
            return true;
        }
    }
}
