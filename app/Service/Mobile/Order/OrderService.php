<?php

namespace App\Service\Mobile\Order;

use App\Http\Resources\Mobile\Order\OrderResource;
use App\Models\Branch\Branch;
use App\Models\Finance\WalletOrder;
use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Service\Payment\NoonPaymentService;
use App\Traits\apiResponse;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    use apiResponse;

    protected $createOrderService;

    protected $customer;


    public function __construct(CreateOrderService $createOrderService, private NoonPaymentService $noonPaymentService)
    {
        $this->createOrderService = $createOrderService;

        $this->customer = Auth::guard('mobile')->user();
    }

    public function getOrders()
    {
        $orders = Order::where('customer_id', $this->customer->id)->where('type', '!=', 'point')->latest()->with('items')->latest()->paginate(10);

        return OrderResource::collection($orders);
    }

    public function showOrder($id)
    {
        $order = Order::where('customer_id', $this->customer->id)->find($id);

        if (!$order) {  return $this->notFound();  }

        return new OrderResource($order);
    }

    public function normalOrder($request)
    {
        $cart = Cart::where('customer_id', $this->customer->id)->where('status', 'pending')->first();

        if (!$cart) {  return $this->error(__('Cart Not Found')); }

        /* Check if the branch is open */

        $branch = Branch::find($cart->branch_id);

        if(!$branch){
            return $this->error(__('Branch not found'));
        }

        $openStatus = canOrder($branch->id);

        if(!$openStatus){
            return $this->error(__('Branch is closed'));
        }


        $payment_method = $request->payment_method;


        if($payment_method == 'wallet'){


            if ($this->customer->wallet < $cart->grand_total) {
                return $this->error(__('Insufficient Balance'));
            }

            return $this->createOrderService->createOrder($cart, $this->customer, $payment_method, $request);


        }elseif($payment_method == 'visa-wallet'){

                // Partial payment: wallet + visa
                $walletAmount = $this->customer->wallet;

                $remainingAmount = $cart->grand_total - $walletAmount;

                if($remainingAmount <= 0){

                    return $this->createOrderService->createOrder($cart, $this->customer, 'wallet', $request);
                }

                $walletOrder = WalletOrder::create([
                    'customer_id'   => $this->customer->id,
                    'wallet_amount' => $walletAmount,
                    'visa_amount'   => $remainingAmount,
                ]);


           $payment_response = $this->noonPaymentService->initiatePayment($cart, $request, 'product', null, $walletOrder);

                if($payment_response['status']){

                return response()->json([
                    'success' => true,
                    'message' => __('Link Generated Successfully'),
                    'payment_url' => $payment_response['payment_url']
                ]);

                }

                return response()->json([
                    'success' => false,
                    'message' => __('Payment Failed'),
                    'payment_url' => $payment_response
                ]);

        } elseif($payment_method == 'points'){

            if ($this->customer->points < $cart->grand_total) {
                return $this->error(__('Insufficient Points'));
            }

            return $this->createOrderService->createOrder($cart, $this->customer, 'points', $request);

        } else{

             $payment_response = $this->noonPaymentService->initiatePayment($cart, $request);

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
}
