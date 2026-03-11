<?php

namespace App\Http\Controllers\Mobile\Order;

use App\Http\Controllers\Controller;
use App\Service\Mobile\Coupon\CouponService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function __construct(private CouponService $couponService){}

    /**
     * Check if a coupon is valid and can be used
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request): JsonResponse
    {
        return $this->couponService->check($request);
    }

    /**
     * Apply coupon to cart
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function apply(Request $request)
    {
        return $this->couponService->apply($request);
    }

    public function deleteCoupon(Request $request)
    {
        return $this->couponService->deleteCoupon($request);
    }




}
