<?php

namespace App\Service\Payment;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use App\Models\Finance\Payment;
use App\Models\Gift\Gift;
use App\Models\Order\Cart;
use App\Models\Order\Gift\GiftCart;
use App\Notifications\Customer\NewGiftNotification;
use App\Service\Mobile\Order\CreateOrderService;
use App\Service\Mobile\Order\GiftOrderService;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class PaymentResponseService
{
    use apiResponse;

    public function __construct(
        private CreateOrderService $createOrderService,
        private GiftOrderService $giftOrderService
        )
    {}

    public function response($payment_id, $request, $transactionId)
    {

        $payment = Payment::find($payment_id);

        if(!$payment){
         return redirect()->route('payment.failed');
        }

        if($payment->status == 'paid'){
         return redirect()->route('payment.failed');
        }

        if($payment->type == 'product'){

          return $this->createNormalOrder($payment, $request, $transactionId);

        }elseif($payment->type == 'gift'){

         return $this->createGiftOrder($payment, $transactionId);

        }elseif($payment->type == 'gift_money'){

         return $this->createGiftMoneyOrder($payment, $transactionId);

        }
   }

    private function createNormalOrder($payment, $request = null, $transactionId)
    {

        $cart = Cart::find($payment->order_id);

        $customer = Customer::find($payment->customer_id);

        if(!$payment || !$cart || !$customer){
            return redirect()->route('payment.failed');
        }

        $request = new \Illuminate\Http\Request([
            'place' => $payment->place,
            'note' => $payment->note,
            'message' => $payment->message,
            'car_details' => $payment->car_details,
            'wallet_order_id' => $payment->wallet_order_id,
        ]);

      $createOrder = $this->createOrderService->storeOrder($cart, $customer, null,'visa', $request, true, $transactionId);

      $status = $createOrder['status'];

      if($status == 'success'){

        $payment->update([
         'status' => 'paid',
         'payment_transaction_id' => $transactionId,
        ]);

        return  redirect()->route('payment.success');

      }

        return redirect()->route('payment.failed');
    }

    private function createGiftOrder($payment, $transactionId)
    {

        $sendTo = Customer::find($payment->receiver_id);

        $customer = Customer::find($payment->customer_id);

        $cart = GiftCart::find($payment->order_id);

        $request = new \Illuminate\Http\Request([

            'note' => $payment->note,
            'message' => $payment->message,
         ]);

        $this->giftOrderService->storeOrder($cart, $customer, $sendTo, $payment->payment_method, $request, $transactionId);


        // $payment->receiver->notify(new NewGiftNotification($gift, $payment->customer, 'gift'));

        $sendTo->notify(new NewGiftNotification('new gift', $customer, 'gift'));


        $payment->update([
            'status' => 'paid',
            'payment_transaction_id' => $transactionId,
           ]);


        return  redirect()->route('payment.success');

    }


    private function createGiftMoneyOrder($payment, $transactionId)
    {

        $gift = Gift::create([
            'sender_id'   => $payment->customer_id,
            'receiver_id' => $payment->receiver_id,
            'amount'      => $payment->amount,
            'message'     => $payment->message,
            'payment_method' => $payment->payment_method,
            'payment_id'     => $transactionId,
        ]);

        $sendTo = Customer::find($payment->receiver_id);

        $customer = Customer::find($payment->customer_id);


        $this->handleFinance($payment, $sendTo, $customer);

        // $payment->receiver->notify(new NewGiftNotification($gift, $payment->customer, 'gift'));

        $payment->update([
            'status' => 'paid',
            'payment_transaction_id' => $transactionId,
           ]);


        return  redirect()->route('payment.success');

    }

    private function handleFinance($payment, $sendTo, $customer)
    {
        $sendTo->update([
            'wallet' => $sendTo->wallet + $payment->amount,
        ]);

        if($payment->payment_method == 'wallet'){

            $customer->update([
                'wallet' => $customer->wallet - $payment->amount,
            ]);

            CustomerWallet::create([
                'customer_id' => $customer->id,
                'amount'      => $payment->amount,
                'type'        => 'out',
                'ar_content'  => 'تم إرسال هدية من ' . $customer->name . ' إلى ' . $sendTo->name,
                'en_content'  => 'Gift Sent from ' . $customer->name . ' to ' . $sendTo->name,
               ]);
        }


           CustomerWallet::create([
            'customer_id' => $sendTo->id,
            'amount'      => $payment->amount,
            'type'        => 'in',
            'ar_content'  => 'تم استلام هدية من ' . $customer->name,
            'en_content'  => 'Gift Received from ' . $customer->name,
           ]);

    }

}
