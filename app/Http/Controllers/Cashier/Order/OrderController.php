<?php

namespace App\Http\Controllers\Cashier\Order;

use App\Http\Controllers\Controller;
    use App\Http\Resources\Cashier\Order\OrderResource;
    use App\Http\Resources\Cashier\Order\SingleOrderResource;
use App\Models\Customer\CustomerPoint;
use App\Models\Order\Gift\GiftOrder;
use App\Models\Order\Order;
use App\Notifications\Cashier\OrderStatusNotification;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function confirm(string $id)
    {
        $order = Order::with('customer')->find($id);

        if(!$order) { return $this->notFound(); }

        if($order->status != 'pending') { return $this->error(__('Order is not pending')); }

        $order->update(['status' => 'processing']);

        // Send notification asynchronously
        $order->customer->notify(new OrderStatusNotification($order, 'confirmed'));

        return $this->success(__('Order confirmed'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function ready(string $id, string $type)
    {
        $order = $type === 'order' ? Order::with('customer')->find($id) : GiftOrder::with('customer')->find($id);

        if(!$order) { return $this->notFound(); }

        if($order->status != 'processing') { return $this->error(__('Order is not processing')); }

        $order->update(['status' => 'ready']);

        // Send notification asynchronously
        $order->customer->notify(new OrderStatusNotification($order, 'ready'));

        return $this->success(__('Order ready'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function complete(string $id, string $type)
    {
        $order = $type === 'order' ? Order::with('customer')->find($id) : GiftOrder::with('customer')->find($id);

        if(!$order) { return $this->notFound(); }

        if($order->status != 'ready') { return $this->error(__('Order is not ready')); }

        $order->update(['status' => 'completed']);

        // Send notification asynchronously
        $order->customer->notify(new OrderStatusNotification($order, 'completed'));

        return $this->success(__('Order completed'));
    }

    /**
     * Display the specified resource.
     */
    public function cancel(string $id)
    {
        $order = Order::with('customer')->find($id);

        if(!$order) { return $this->notFound(); }

        if($order->status != 'pending') { return $this->error(__('Order is not pending')); }

        $order->customer->update(['points' => $order->customer->points - $order->points]);
        
        $order->update(['status' => 'cancelled']);

        // Send notification asynchronously
        $order->customer->notify(new OrderStatusNotification($order, 'cancelled'));

        // delete CustomerPoint
        try {
            CustomerPoint::where('order_id', $order->id)->delete();
        } catch (\Exception $e) {
            Log::error('Failed to delete CustomerPoint: ' . $e->getMessage());
        }

        return $this->success(__('Order cancelled'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id, string $type)
    {
        $order = $type === 'order' ? Order::find($id) : GiftOrder::find($id);

        if(!$order) { return $this->notFound(); }

        return new SingleOrderResource($order);
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
