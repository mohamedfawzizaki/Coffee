<?php

namespace App\Http\Controllers\Cashier\Qr;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\Order\OrderResource;
use App\Http\Resources\Mobile\Order\GiftOrder\GiftOrderResource;
use App\Models\Order\Gift\GiftOrder;
use App\Models\Order\Order;
use App\Traits\apiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QrCodeController extends Controller
{
    use apiResponse;

    public function get(Request $request)
    {
        $request->validate([
            'type' => 'required|in:gift,point',
            'id'   => 'required|integer|min:1',
        ]);

        $order = $this->findOrder($request->type, $request->id);

        if (!$order) {
            return $this->error(__('Order Not Found'), 404);
        }

        if ($order->received) {
            return $this->error(__('Order Already Received'), 400);
        }

        return $request->type === 'gift'
            ? new GiftOrderResource($order)
            : new OrderResource($order);
    }



    /**
     * Mark an order as received
     */
    public function receive(Request $request)
    {
        $request->validate([
            'type' => 'required|in:gift,point',
            'id'   => 'required|integer|min:1',
        ]);

        $order = $this->findOrder($request->type, $request->id);

        if (!$order) {
            return $this->error(__('Order Not Found'), 404);
        }

        if ($order->received) {
            return $this->error(__('Order Already Received'), 400);
        }

        $order->update([
            'status' => 'processing',
            'received' => true,
            'received_at' => now(),
            'branch_id' => Auth::guard('cashier')->user()->branch_id ?? null    ,
            'manager_id' => Auth::guard('cashier')->user()->id ?? null,
        ]);

        return $this->success(__('Order Received Successfully'));
    }

    /**
     * Find order by type and id
     *
     * @param string $type
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private function findOrder(string $type, int $id)
    {
        return $type === 'gift'
            ? GiftOrder::find($id)
            : Order::find($id);
    }

}
