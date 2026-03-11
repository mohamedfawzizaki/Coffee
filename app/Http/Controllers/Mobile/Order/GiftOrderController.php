<?php

namespace App\Http\Controllers\Mobile\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Ordert\Cart\GiftOrderRequest;
use App\Http\Resources\Mobile\Customer\CustomerResource;
use App\Models\Customer\Customer;
use App\Service\Mobile\Order\GiftOrderService;
use Illuminate\Http\Request;

class GiftOrderController extends Controller
{
    protected $orderService;

    public function __construct(GiftOrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return $this->orderService->getOrders();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftOrderRequest $request)
    {
        return $this->orderService->normalOrder($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->orderService->showOrder($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function customerCheck(Request $request)
    {
        $customer = Customer::where('phone', $request->phone)->first();

        if (!$customer) {
            return $this->error(__('Customer Not Found'));
        }

        return new CustomerResource($customer);
    }
}
