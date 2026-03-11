<?php

namespace App\Http\Controllers\Mobile\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Ordert\Cart\CartQuantityRequest;
use App\Http\Requests\Mobile\Ordert\Cart\CartRequest;
use App\Service\Mobile\Cart\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->cartService->getCart();
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request)
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


    public function updateQuantityPlus(CartQuantityRequest $request)
    {
        return $this->cartService->updateQuantityPlus($request);
    }

    public function updateQuantityMinus(CartQuantityRequest $request)
    {
        return $this->cartService->updateQuantityMinus($request);
    }

}
