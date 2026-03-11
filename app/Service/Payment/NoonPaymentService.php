<?php

namespace App\Service\Payment;

use App\Models\Finance\Payment;
use App\Traits\apiResponse;
use Illuminate\Support\Facades\Auth;
use App\Traits\Payment as PaymentTrait;
class NoonPaymentService
{
    use apiResponse, PaymentTrait;


    public function initiatePayment($cart = null, $request, $type = 'product', $sendTo = null, $walletOrder = null)
    {

        $customer = Auth::guard('mobile')->user();

        $order_id = 'NPAEORD' . rand(1000000000, 9999999999);

        if($walletOrder){

            $amount = $walletOrder->visa_amount;

        }else{

            $amount = $cart ? $cart->grand_total : $request->amount;
        }

      $payment = Payment::create([
            'customer_id' => $customer->id,
            'amount' => $amount,
            'status' => 'pending',
            'type' => $type,
            'order_id' => $cart ? $cart->id : null,
            // 'payment_data' => $response,
            'payment_order_id' => $order_id,
            // 'payment_transaction_id' => $result->transactions[0]->id,
            'payment_method' => 'noon',
            'place' => $request->place,
            'note' => $request->note,
            'message' => $request->message,
            'car_details' => $request->car_details,
            'receiver_id' => $sendTo ? $sendTo->id : null,
            'wallet_order_id' => $walletOrder ? $walletOrder->id : null,
            'wallet_amount' => $walletOrder? $walletOrder->wallet_amount : 0,
            'visa_amount'   => $walletOrder? $walletOrder->visa_amount : 0,
        ]);

        if($walletOrder){
            $walletOrder->update([
                'payment_id' => $payment->id,
            ]);

            $grand_total = $walletOrder->visa_amount;
        }else{

            $grand_total = $cart ? $cart->grand_total : $request->amount;
        }

       $payment_response = $this->payment($grand_total, $customer, $payment->id);

       if($payment_response['status'] == false){

          return   $payment_response;

       }

            return $payment_response;

    }

}
