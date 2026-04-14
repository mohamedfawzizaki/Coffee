<?php

namespace App\Livewire\Dashboard\Order;

use App\Models\Order\Order;
use App\Service\Dashboard\Order\RefundOrderItemService;
use Livewire\Attributes\Title;
use Livewire\Component;

class OrderShow extends Component
{
    public $order;

    public $status;

    public function mount($id)
    {
        $this->order = Order::with(['branch', 'customer', 'items.product', 'items.size'])->findOrFail($id);

        $this->status = $this->order->status;
    }

    #[Title('Order Details')]
    public function render()
    {
        return view('livewire.dashboard.order.product-order-show');
    }

    public function updateStatus()
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->id == 1;
        abort_unless($isSuperAdmin || $user->isAbleTo('order-update'), 403);

        $this->order->status = $this->status;

        $this->order->save();

        request()->session()->flash('success', __('Status updated successfully'));

        $this->redirect('/dashboard/order/show/' . $this->order->id, navigate: true);
    }

    public function refundItem($itemId)
    {
        $user = auth('admin')->user();
        $isSuperAdmin = $user->id == 1;
        abort_unless($isSuperAdmin || $user->isAbleTo('order-update'), 403);

        $item = $this->order->items->firstWhere('id', $itemId);

        if (!$item) {
            request()->session()->flash('error', __('Item not found'));
            return;
        }

        $service = new RefundOrderItemService();
        $result  = $service->refund($this->order, $item);

        if ($result['success']) {
            // Refresh order after refund
            $this->order = Order::with(['branch', 'customer', 'items.product', 'items.size'])->findOrFail($this->order->id);
            request()->session()->flash('success', $result['message']);
        } else {
            request()->session()->flash('error', $result['message']);
        }
    }
}
