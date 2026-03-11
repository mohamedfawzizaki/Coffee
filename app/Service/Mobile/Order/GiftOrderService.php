<?php

namespace App\Service\Mobile\Order;

use App\Http\Resources\Mobile\Order\GiftOrder\GiftOrderResource;
use App\Http\Resources\Mobile\Order\OrderResource;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPoint;
use App\Models\Order\Gift\GiftCart;
use App\Models\Order\Gift\GiftOrder;
use App\Models\Order\Gift\GiftOrderItem;
use App\Notifications\Customer\NewGiftNotification;
use App\Service\Payment\NoonPaymentService;
use App\Traits\apiResponse;
use App\Traits\QR;
use Illuminate\Support\Facades\Auth;

class GiftOrderService
{
    use apiResponse, QR;

    protected $createOrderService;

    protected $customer;


    public function __construct(CreateOrderService $createOrderService, private NoonPaymentService $noonPaymentService)
    {
        $this->createOrderService = $createOrderService;

        $this->customer = Auth::guard('mobile')->user();
    }

    public function getOrders()
    {
        $orders = GiftOrder::where('customer_id', $this->customer->id)->latest()->with('items')->get();

        return response()->json([
            'customer_points' => $this->customer->points,
            'customer_wallet' => $this->customer->wallet,
            'orders' => GiftOrderResource::collection($orders),
        ]);

    }

    public function showOrder($id)
    {
        $order = GiftOrder::where('customer_id', $this->customer->id)->find($id);

        if (!$order) {  return $this->notFound();  }

        return new GiftOrderResource($order);
    }

    public function normalOrder($request)
    {

        $cart = GiftCart::where('customer_id', $this->customer->id)->where('status', 'pending')->first();

        if (!$cart) {  return $this->error(__('Cart Not Found')); }

        $payment_method = $request->payment_method;

        if($payment_method == 'wallet'){

            if ($this->customer->wallet < $cart->grand_total) {
                return $this->error(__('Insufficient Balance'));
            }

            return $this->createOrder($cart, $this->customer, $payment_method, $request);

        }else{

            $sendTo = Customer::where('phone', $request->phone)->first();

            if(!$sendTo){
                return $this->error(__('Customer Not Found'));
            }

            return $payment_url = $this->noonPaymentService->initiatePayment($cart, $request, 'gift', $sendTo);


        }


    }


    public function createOrder($cart, $customer, $payment_method, $request)
    {


            $phone    = $request->phone;

            $sendTo = Customer::where('phone', $phone)->first();

            if(!$sendTo){
                return $this->error(__('Customer Not Found'));
            }

            return $this->storeOrder($cart, $customer, $sendTo, $payment_method, $request, 'gift');

    }

    public function storeOrder($cart, $customer, $sendTo, $payment_method, $request, $payment_id = null)
    {
        $points = $this->createOrderService->calculatePoints($cart);

        $order = GiftOrder::create([
            'customer_id'    => $customer->id,
            'send_to'        => $sendTo?->id,
            // 'coupon_id'      => $cart->coupon_id,
            'points'         => $points,
            'total'          => $cart->total,
            'discount'       => $cart->discount,
            'tax'            => 0,
            'grand_total'    => $cart->grand_total,
            // 'visa'           => $cart->visa,
            // 'wallet'         => $cart->wallet,
            'payment_method' => $payment_method,
            'payment_status' => 'paid',
            'payment_id'     => $payment_id,
            'note'           => $request->note,
            'message'        => $request->message,
        ]);

        $order->qr = $this->createQr($order->id, 'gift');

        $order->save();

        foreach ($cart->items as $item) {
            $costPrice = 0;
            if ($item->size_id) {
                $costPrice = Productsize::find($item->size_id)?->cost_price ?? 0;
            } else {
                $costPrice = Product::find($item->product_id)?->cost_price ?? 0;
            }

            GiftOrderItem::create([
                'gift_order_id'  => $order->id,
                'product_id'   => $item->product_id,
                'quantity'     => $item->quantity,
                'price'        => $item->price,
                'cost_price'   => $costPrice,
                'total'        => $item->total,
                'size_id'      => $item->size_id,
            ]);
        }

        $cart->delete();

        $customer->points += $points;

        $customer->save();

        // OrderLog::create([
        //     'order_id'    => $order->id,
        //     'customer_id' => $customer->id,
        //     'en_content'  => 'Order Created ' . $order->id,
        //     'ar_content'  => 'تم إنشاء الطلب ' . $order->id,
        // ]);

        CustomerPoint::create([
            'customer_id' => $customer->id,
            'order_id'    => $order->id,
            'amount'      => round($points),
            'ar_content'  => 'تم إنشاء الطلب' . ' ' . $order->id,
            'en_content'  => 'Order Created' . ' ' . $order->id,
            'type'        => 'in',
            'order_type'  => 'gift',
        ]);

        $sendTo->notify(new NewGiftNotification($order, $customer, 'gift'));

        return $this->success(__('Order Created Successfully'));

    }



}
