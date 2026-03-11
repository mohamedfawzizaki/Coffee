<?php

namespace App\Service\Mobile\Coupon;

use App\Models\Finance\Coupon;
use App\Models\Order\Cart;
use App\Models\Order\Order;
use App\Service\Mobile\BaseMobileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponService extends BaseMobileService
{
    public function check(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        $validationResult = $this->couponValidation($coupon);

        if ($validationResult !== true) {
            return $validationResult;
        }

        return response()->json([
            'success' => true,
            'message' => __('Coupon Valid'),
            'coupon' => $coupon,
        ]);
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code'    => 'required|string|max:255',
            'cart_id' => 'required|exists:carts,id',
        ]);

        $coupon = Coupon::where('code', $request->code)->first();

        $validationResult = $this->couponValidation($coupon);

        if ($validationResult !== true) {
            return $validationResult;
        }

        $cart = Cart::find($request->cart_id);


        if (!$cart) {
            return $this->error(__('Cart Not Found'));
        }

        if(!is_null($cart->coupon_id)){
            return $this->error(__('Coupon Already Applied'));
        }

        if ($cart->grand_total < $coupon->min_order_amount) {
            return response()->json([
                'success' => false,
                'message' => __('Cart Total Is Less Than Coupon Min Order Amount')
            ], 400);
        }

         $discount = $this->calculateDiscount($coupon, $cart->grand_total) ?? 0;

        $grandTotal = $cart->grand_total - $discount;

        if ($grandTotal < 0) {
            $grandTotal = 0;
        }

        $cart->grand_total = $grandTotal;
        $cart->discount     = $discount;
        $cart->coupon_id    = $coupon->id;
        $cart->save();

        return response()->json([
            'success' => true,
            'message' => __('Coupon Applied Successfully'),
            'data' => [
                'discount' => $discount,
                'new_total' => $cart->grand_total
            ]
        ]);
    }

    public function deleteCoupon(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
        ]);

        $cart = Cart::find($request->cart_id);

        if (!$cart) {
            return $this->error(__('Cart Not Found'));
        }

        if(is_null($cart->coupon_id)){
            return $this->error(__('No Coupon Applied'));
        }

         $cart->update([
            'coupon_id' => null,
            'discount' => 0,
            'grand_total' => $cart->total,
         ]);

        return $this->success(__('Coupon Deleted Successfully'));
    }

        /**
     * Validate coupon and return appropriate response if invalid
     *
     * @param Coupon|null $coupon
     * @return JsonResponse|true
     */
    private function couponValidation(?Coupon $coupon): JsonResponse|bool
    {
        if (!$coupon) {
            return $this->error(__('Coupon Not Found'));
        }

        if ($this->isCouponExpired($coupon)) {
            return $this->error(__('Coupon Expired'));
        }

        if ($this->hasReachedMaxUsage($coupon)) {
            return $this->error(__('Coupon Max Usage'));
        }

        if ($this->hasReachedMaxUsagePerUser($coupon)) {
            return $this->error(__('Coupon Max Usage Per User'));
        }

        return true;
    }

    /**
     * Calculate discount amount based on coupon type and rules
     *
     * @param Coupon $coupon
     * @param float $grandTotal
     * @return float
     */
    private function calculateDiscount(Coupon $coupon, float $grandTotal)
    {
        $discount = match($coupon->type) {
            'percentage' => $grandTotal * $coupon->amount / 100,
            'fixed'      => $coupon->amount,
            default => 0
        };



        return min($discount, $coupon->max_discount_amount);
    }

    /**
     * Check if coupon is expired
     *
     * @param Coupon $coupon
     * @return bool
     */
    private function isCouponExpired(Coupon $coupon): bool
    {
        return $coupon->expire_date < now() || $coupon->status == 0;
    }

    /**
     * Check if coupon has reached maximum usage
     *
     * @param Coupon $coupon
     * @return bool
     */
    private function hasReachedMaxUsage(Coupon $coupon): bool
    {
        $usage = Order::where('coupon_id', $coupon->id)->count();

        return $usage >= $coupon->max_usage;
    }

    /**
     * Check if user has reached maximum usage of the coupon
     *
     * @param Coupon $coupon
     * @return bool
     */
    private function hasReachedMaxUsagePerUser(Coupon $coupon): bool
    {
        $userUsage = Order::where('coupon_id', $coupon->id)
            ->where('customer_id', auth('mobile')->user()->id)
            ->count();
        return $userUsage >= $coupon->max_usage_per_user;
    }


}