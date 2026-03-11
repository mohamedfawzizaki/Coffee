<?php

namespace App\Service\Mobile\Order;

use App\Models\Customer\CustomerPoint;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Order\OrderLog;
use App\Models\Product\Product\Product;
use App\Traits\apiResponse;
use App\Traits\QR;
use Illuminate\Support\Facades\Auth;

class PointReplaceService
{
    use apiResponse, QR;

    protected $customer;

    public function __construct()
    {
        $this->customer = Auth::guard('mobile')->user();
    }

    public function storePointReplace($request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);


        $product = Product::find($request->product_id);

        if (!$product) {
            return $this->error(__('Product Not Found'));
        }

        if ($product->can_replace == 0) {
            return $this->error(__('Product Cannot Be Replaced'));
        }

        if ($this->customer->points < $product->points) {
            return $this->error(__('Insufficient Points'));
        }


        $order = Order::create([
            'customer_id'    => $this->customer->id,
            'coupon_id'      => null,
            'manager_id'     => null,
            'product_id'     => $product->id,
            'type'           => 'point',
            'points'         => $product->points,
            'total'          => $product->points,
            'discount'       => 0,
            'tax'            => 0,
            'grand_total'    => $product->points,
            'payment_method' => 'points',
            'payment_status' => 'paid',
        ]);

        $order->qr = $this->createQr($order->id, 'point');

        $order->save();

            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $product->id,
                'quantity'     => 1,
                'price'        => $product->points,
                'total'        => $product->points,
                'size_id'      => null,
            ]);

        OrderLog::create([
            'order_id'    => $order->id,
            'customer_id' => $this->customer->id,
            'en_content'  => 'Order Created ' . $order->id,
            'ar_content'  => 'تم إنشاء الطلب ' . $order->id,
        ]);


       $this->handleFinance($order, $product->points);

       return response()->json([
        'status' => 'success',
        'message' => __('Points Replaced Successfully'),
        'order' => $order,
       ]);

     }


    public function handleFinance($order,  $points)
    {
        CustomerPoint::create([
            'customer_id' => $this->customer->id,
            'order_id'    => $order->id,
            'amount'      => round($points),
            'ar_content'  => 'تم استبدال النقاط بمنتج' . ' ' . $order->id,
            'en_content'  => 'Points Replaced with Product' . ' ' . $order->id,
            'type'        => 'out',
        ]);

        $this->customer->points -= $points;

        $this->customer->save();
    }

}
