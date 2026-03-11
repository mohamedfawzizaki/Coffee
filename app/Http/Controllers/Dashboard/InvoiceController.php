<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Models\General\Setting;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $order = Order::with([
            'customer',
            'branch',
            'items.product',
            'items.size',
            'coupon',
        ])->findOrFail($id);

        $setting = Setting::first();

        return view('dashboard.order.invoice', compact('order', 'setting'));
    }
}
