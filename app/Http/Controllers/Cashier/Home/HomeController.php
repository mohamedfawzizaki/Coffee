<?php

namespace App\Http\Controllers\Cashier\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\Cashier\Order\OrderResource;
use App\Models\Order\Gift\GiftOrder;
use App\Models\Order\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $cashier;

    public function __construct()
    {
        $this->cashier = Auth::guard('cashier')->user();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Pending
        $pending = Order::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'order';
                return $order;
            });

        $giftPending = GiftOrder::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'pending')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'gift';
                return $order;
            });

        $allPending = $pending->merge($giftPending)->sortByDesc('created_at')->values();

        // Processing
        $processing = Order::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'processing')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'order';
                return $order;
            });

        $giftProcessing = GiftOrder::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'processing')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'gift';
                return $order;
            });

        $allProcessing = $processing->merge($giftProcessing)->sortByDesc('created_at')->values();

        // Ready
        $ready = Order::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'ready')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'order';
                return $order;
            });

        $giftReady = GiftOrder::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'ready')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'gift';
                return $order;
            });

        $allReady = $ready->merge($giftReady)->sortByDesc('created_at')->values();

        // Completed
        $completed = Order::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'completed')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'order';
                return $order;
            });

        $giftCompleted = GiftOrder::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'completed')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'gift';
                return $order;
            });

        $allCompleted = $completed->merge($giftCompleted)->sortByDesc('created_at')->values();

        // Cancelled
        $cancelled = Order::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'cancelled')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'order';
                return $order;
            });

        $giftCancelled = GiftOrder::where('branch_id', $this->cashier->branch_id)
            ->where('status', 'cancelled')
            ->latest()
            ->get()
            ->map(function ($order) {
                $order->order_type = 'gift';
                return $order;
            });

        $allCancelled = $cancelled->merge($giftCancelled)->sortByDesc('created_at')->values();

        $unreadNotifications = $this->cashier->unreadNotifications()->count();


        return response()->json([
            'unreadNotifications' => $unreadNotifications,
            'current' => [
                'pending'    =>  OrderResource::collection($allPending),
                'processing' =>  OrderResource::collection($allProcessing),
                'ready'      =>  OrderResource::collection($allReady),
            ],
            'completed' =>  OrderResource::collection($allCompleted),
            'cancelled' =>  OrderResource::collection($allCancelled),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function changeStatus(Request $request)
    {
        //    change branch status toggle

        $user = Auth::guard('cashier')->user();

        $branch = $user->branch;

        if($branch->status) {
            $branch->update(['status' => 0]);
        } else {
            $branch->update(['status' => 1]);
        }

        return $this->success(__('Branch status changed successfully'));

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
