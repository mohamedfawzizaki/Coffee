<?php

namespace App\Service\Mobile\Order;

use App\Models\Customer\CustomerPoint;
use App\Models\Customer\CustomerWallet;
use App\Models\Finance\WalletOrder;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\OrderLog;
use App\Traits\apiResponse;

class CreateOrderService
{
    use apiResponse;


    public function createOrder($cart, $customer, $payment_method, $request)
    {

        return $this->storeOrder($cart, $customer, null,$payment_method, $request);
    }

    public function storeOrder($cart, $customer, $sendTo, $payment_method, $request, $from_payment = false, $payment_id = null)
    {
        if(!$cart || is_null($cart)){
            return $this->error(__('Cart Not Found'));
        }

        $points = $this->calculatePoints($cart);

        if($request->wallet_order_id){

            $walletOrder = WalletOrder::find($request->wallet_order_id);
            $walletAmount = $walletOrder->wallet_amount;
            $visaAmount = $walletOrder->visa_amount;


        } else {
            $walletAmount = 0;
            $visaAmount = $cart->grand_total;
        }

        $order = Order::create([
            'customer_id'    => $customer->id,
            'send_to'        => $sendTo?->id,
            'branch_id'      => $cart->branch_id,
            'coupon_id'      => $cart->coupon_id,
            'manager_id'     => $cart->manager_id,
            'product_id'     => $cart->product_id,
            'points'         => $points,
            'total'          => $cart->total,
            'discount'       => $cart->discount,
            'tax'            => 0,
            'grand_total'    => $cart->grand_total,
            'visa'           => $visaAmount,
            'wallet'         => $walletAmount,
            'payment_method' => $payment_method,
            'type'           => $payment_method == 'points' ? 'point' : 'order',
            'payment_status' => 'paid',
            'payment_id'     => $payment_id,
            'place'          => $request->place,
            'note'           => $request->note,
            'message'        => $request->message,
            'car_details'    => $request->car_details,
        ]);

        foreach ($cart->items as $item) {
            $costPrice = 0;
            if ($item->size_id) {
                $costPrice = \App\Models\Product\Product\Productsize::find($item->size_id)?->cost_price ?? 0;
            } else {
                $costPrice = \App\Models\Product\Product\Product::find($item->product_id)?->cost_price ?? 0;
            }

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $item->product_id,
                'quantity'     => $item->quantity,
                'price'        => $item->price,
                'cost_price'   => $costPrice,
                'total'        => $item->total,
                'size_id'      => $item->size_id,
            ]);
        }


        // Update wallet order
        if($request->wallet_order_id){

            $walletOrder->update([
                'order_id' => $order->id,
            ]);

            CustomerWallet::create([
                'customer_id' => $customer->id,
                'order_id'    => $order->id,
                'amount'      => $walletAmount,
                'type'        => 'out',
                'ar_content'  =>  'دفع جزء من الطلب باستخدام المحفظة ' . $walletAmount . ' SAR للطلب ' . $order->id,
                'en_content'  => 'Part of the order paid using wallet ' . $walletAmount . ' SAR for order ' . $order->id . ' SAR amount',
            ]);

            $customer->update([
                'wallet' => $customer->wallet - $walletAmount,
            ]);

        }


        $cart->delete();

        OrderLog::create([
            'order_id'    => $order->id,
            'customer_id' => $customer->id,
            'en_content'  => 'Order Created ' . $order->id,
            'ar_content'  => 'تم إنشاء الطلب ' . $order->id,
        ]);

        $this->handleFinance($order, $customer, $points, $payment_method);

        if($from_payment){
            return [
                'status' => 'success',
                'message' => __('Order Created Successfully'),
                'order' => $order,
            ];
        }


        return $this->success(__('Order Created Successfully'));
    }

    public function calculatePoints($cart)
    {
        return customerMoneyToPoint($cart->customer_id, $cart->grand_total);
    }

    public function handleFinance($order, $customer, $points, $payment_method)
    {
        CustomerPoint::create([
            'customer_id' => $customer->id,
            'order_id'    => $order->id,
            'amount'      => round($points),
            'ar_content'  => 'تم إنشاء الطلب' . ' ' . $order->id,
            'en_content'  => 'Order Created' . ' ' . $order->id,
            'type'        => 'in',
        ]);

        if($payment_method == 'wallet'){

            CustomerWallet::create([
                'customer_id' => $customer->id,
                'order_id'    => $order->id,
                'amount'      => $order->grand_total,
                'type'        => 'out',
                'ar_content'  => 'تم إنشاء الطلب' . ' ' . $order->id,
                'en_content'  => 'Order Created' . ' ' . $order->id,
            ]);

            $customer->wallet -= $order->grand_total;

            $customer->save();
        }

        $customer->points += $points;

        $customer->save();

    }
}
