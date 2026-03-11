<?php

namespace App\Http\Controllers\Mobile\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Finance\PointResource;
use App\Http\Resources\Mobile\Finance\WalletResource;
use App\Models\Customer\CustomerWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinanceController extends Controller
{

    protected $customer;
    public function __construct()
    {
        $this->customer = Auth::guard('mobile')->user();
    }

    /**
     * Display a listing of the resource.
     */
    public function wallet()
    {
        $all = CustomerWallet::where('customer_id', $this->customer->id)->latest()->get();

        $in = $all->where('type', 'in');

        $out = $all->where('type', 'out');

        return [
            'wallet_amount' => number_format($this->customer->wallet, 2),
            'all_transactions' => WalletResource::collection($all),
            'in_transactions' => WalletResource::collection($in),
            'out_transactions' => WalletResource::collection($out),
        ];

     }


    public function points()
    {
        return [
            'points' => PointResource::collection($this->customer->pointsRecords),
            'total'  => $this->customer->points,
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
