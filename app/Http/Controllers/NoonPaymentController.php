<?php

namespace App\Http\Controllers;

use App\Models\Order\Order;
use App\Service\Payment\NoonPaymentService;
use Illuminate\Http\Request;

class NoonPaymentController extends Controller
{

    public function __construct(private NoonPaymentService $noonPaymentService){}

    public function index()
    {
        $order = Order::first();

        $response = $this->noonPaymentService->initiatePayment($order, request());

        dd($response);
    }

    public function response(Request $request)
    {
       return $this->noonPaymentService->response($request);

    }

}
