<?php

namespace App\Http\Controllers\Mobile\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Ordert\Cart\GiftCartRequest;
use App\Http\Resources\Mobile\Cart\GiftCart\GiftCartResource;
use App\Models\Order\Gift\GiftCart;
use App\Service\Mobile\Cart\GiftCartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftCartController extends Controller
{
    protected $cartService;

    public function __construct(GiftCartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $cart = GiftCart::where('customer_id', Auth::guard('mobile')->user()->id)->where('status', 'pending')->first();

        if (!$cart) {
            return $this->error(__('Cart Is Empty'));
        }

        return  new GiftCartResource($cart);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftCartRequest $request)
    {

        return $this->cartService->store($request);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->cartService->deleteItem($id);

    }

    public function destroyAll()
    {
        return $this->cartService->deleteAll();
    }

}
