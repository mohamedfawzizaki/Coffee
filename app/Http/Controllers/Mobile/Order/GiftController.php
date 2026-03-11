<?php

namespace App\Http\Controllers\Mobile\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Mobile\Gift\GiftStoreRequest;
use App\Service\Mobile\Order\GiftService;
use App\Service\Payment\NoonPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GiftController extends Controller
{
    protected $giftService;

    public function __construct(GiftService $giftService)
    {
        $this->giftService = $giftService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->giftService->getGifts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftStoreRequest $request)
    {

        return $this->giftService->storeGift($request);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
