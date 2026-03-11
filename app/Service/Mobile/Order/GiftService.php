<?php

namespace App\Service\Mobile\Order;

use App\Http\Resources\Mobile\Gift\GiftCardResource;
use App\Http\Resources\Mobile\Order\OrderResource;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerWallet;
use App\Models\Gift\Gift;
use App\Notifications\Customer\NewGiftNotification;
use App\Service\Payment\NoonPaymentService;
use App\Traits\apiResponse;
use Illuminate\Support\Facades\Auth;

class GiftService
{
    use apiResponse;

    protected $customer;

    public function __construct(private NoonPaymentService $noonPaymentService)
    {
        $this->customer = Auth::guard('mobile')->user();
    }

    public function getGifts()
    {

        $receivedProductsGifts = $this->customer->receivedGifts;

        $receivedCardsGifts = Gift::where('receiver_id', $this->customer->id)->latest()->get();

        $sentProductsGifts    = $this->customer->sentGifts;

        $sentCardsGifts = Gift::where('sender_id', $this->customer->id)->latest()->get();


        return response()->json([
            'received' => [
                'products' => OrderResource::collection($receivedProductsGifts),
                'cards'    => GiftCardResource::collection($receivedCardsGifts),
            ],
            'sent' => [
                'products' => OrderResource::collection($sentProductsGifts),
                'cards'    => GiftCardResource::collection($sentCardsGifts),
            ],
            'customer_points' => $this->customer->points,
            'customer_wallet' => $this->customer->wallet,

        ]);
    }

    public function storeGift($request)
    {
        $sendTo = Customer::where('phone', $request->phone)->first();

        if(!$sendTo){
            return $this->error(__('Customer Not Found'));
        }

        if($request->payment_method == 'wallet'){

            $customer = Auth::guard('mobile')->user();

            if($customer->wallet < $request->amount){
                return $this->error(__('Insufficient Balance'));
            }

       $gift = Gift::create([
            'sender_id'   => $this->customer->id,
            'receiver_id' => $sendTo->id,
            'amount'      => $request->amount,
            'message'     => $request->message,
            'payment_method' => $request->payment_method,
        ]);

        $this->handleFinance($request, $sendTo);

        $sendTo->notify(new NewGiftNotification($gift, $this->customer, 'gift'));

        return $this->success(__('Gift Sent Successfully'));

    }else{

        $payment_response = $this->noonPaymentService->initiatePayment(null, $request, 'gift_money', $sendTo);

        if($payment_response['status']){

        return response()->json([
            'success' => true,
            'message' => __('Link Generated Successfully'),
            'payment_url' => $payment_response['payment_url']
        ]);

        }

        return $this->error(__('Payment Failed'));

}


    }

    private function handleFinance($request, $sendTo)
    {
        $sendTo->update([
            'wallet' => $sendTo->wallet + $request->amount,
        ]);

        if($request->payment_method == 'wallet'){

            $this->customer->update([
                'wallet' => $this->customer->wallet - $request->amount,
            ]);

            CustomerWallet::create([
                'customer_id' => $this->customer->id,
                'amount'      => $request->amount,
                'type'        => 'out',
                'ar_content'  => 'تم إرسال هدية من ' . $this->customer->name . ' إلى ' . $sendTo->name,
                'en_content'  => 'Gift Sent from ' . $this->customer->name . ' to ' . $sendTo->name,
               ]);
        }


           CustomerWallet::create([
            'customer_id' => $sendTo->id,
            'amount'      => $request->amount,
            'type'        => 'in',
            'ar_content'  => 'تم استلام هدية من ' . $this->customer->name,
            'en_content'  => 'Gift Received from ' . $this->customer->name,
           ]);

    }


}
