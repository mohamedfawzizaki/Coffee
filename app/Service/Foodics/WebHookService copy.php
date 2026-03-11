<?php

namespace App\Service\Foodics;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\Customer\UnregisteredCustomer;
use App\Models\Foodics\BannedNumber;
use App\Models\Foodics\Foodics;
use App\Traits\QR;
use App\Traits\SendQrCode;
use Illuminate\Support\Facades\Log;

class WebHookServiceCopy
{
    use QR, SendQrCode;

    public function createWebHookOrder($response)
    {
        try {
            $webhookData = json_decode($response, true);

            // Validate received webhook data
            if (!$webhookData || !isset($webhookData['order'])) {
                Log::channel('webhook_error')->error('Invalid webhook data: Missing order data');
                return false;
            }

            $order = $webhookData['order'];

            // Check for required order fields
            if (!isset($order['id']) || !isset($order['reference'])) {
                Log::channel('webhook_error')->error('Invalid webhook data: Missing required order fields');
                return false;
            }

            // Process branch data
            $branchId = null;
            if (isset($order['branch']['id'])) {
                $existingBranch = Branch::where('remote_id', $order['branch']['id'])->first();
                $branchId = $existingBranch?->id;
            }

            // Process customer data
            $customerId = null;

            $customerPhone = null;

            if (isset($order['customer']['phone'])) {

                return $this->handleCustomer($order['customer']['phone'], $order['total_price']);

                // $customerPhone = $order['customer']['phone'];
                // $customer = Customer::where('phone', $customerPhone)->first();
                // $customerId = $customer?->id;
            }

            // Calculate products count
            $productsCount = 0;
            if (isset($order['products']) && is_array($order['products'])) {
                $productsCount = count($order['products']);
            }

            $existsFoodicsOrder = Foodics::where('order_id', $order['id'])->where('reference', $order['reference'])->first();

            if($existsFoodicsOrder){
                return true;
            }


            $existsBannedNumber = BannedNumber::where('number', $customerPhone)->first();

            if($existsBannedNumber){
                return true;
            }

            $foodicsOrder = Foodics::create([
                'branch_id' => $branchId,
                'order_id' => $order['id'],
                'reference' => $order['reference'] ?? null,
                'total_price' => $order['total_price'] ?? 0,
                'customer_id' => $customerId,
                'phone' => $customerPhone,
                'points' => 0,
                'products_count' => $productsCount,
            ]);


            $foodicsOrder->qr = $this->createQr($foodicsOrder->id, 'foodics', 'foodics_qrcode/');

            $foodicsOrder->save();

            $this->sendQrCode($foodicsOrder->qr, $branchId, $foodicsOrder->total_price);

            return true;

        } catch (\Throwable $th) {
            Log::channel('webhook_error')->error('Foodics WebHook Error: ' . $th->getMessage() . ' | Line: ' . $th->getLine() . ' | File: ' . $th->getFile());
            return false;
        }
    }

    public function handleCustomer($customerPhone, $totalPrice)
    {
        $existingCustomer = Customer::where('phone', $customerPhone)->first();

        if($existingCustomer){

            return $this->addPointsToCustomer($existingCustomer, $totalPrice);

        }else{

            return $this->createUnregisteredCustomer($customerPhone, $totalPrice);
        }

     }

    public function addPointsToCustomer($existingCustomer, $totalPrice)
    {
        $existingCustomer->update([
            'points' => $existingCustomer->points + $totalPrice,
        ]);

        return true;
    }


    public function createUnregisteredCustomer($customerPhone, $totalPrice)
    {
        $existingUnregisteredCustomer = UnregisteredCustomer::where('phone', $customerPhone)->first();

        if($existingUnregisteredCustomer){

            $existingUnregisteredCustomer->update([
                'points' => $existingUnregisteredCustomer->points + $totalPrice,
                'orders' => $existingUnregisteredCustomer->orders + 1,
                'total_spent' => $existingUnregisteredCustomer->total_spent + $totalPrice,
            ]);

        }else{

            UnregisteredCustomer::create([
                'phone' => $customerPhone,
                'points' => $totalPrice,
                'orders' => 1,
                'total_spent' => $totalPrice,
            ]);
        }

        return true;

    }
}
