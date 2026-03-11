<?php

namespace App\Livewire\Dashboard\Order;

use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;

class OrderEdit extends Component
{
    public $order;

    public function mount($id)
    {
        $this->order = Order::with(['branch', 'customer', 'items.product', 'items.size'])->findOrFail($id);
    }

    #[Title('Edit Order')]
    public function render()
    {
        return view('livewire.dashboard.order.order-edit');
    }

    public function deleteItem($id)
    {
        $item = OrderItem::find($id);

        if ($item) {
            $item->delete();
        }

        $remainingCount = OrderItem::where('order_id', $this->order->id)->count();

        if ($remainingCount === 0) {

            $this->order->delete();

            $this->redirect('/dashboard/order', navigate: true);
        }


        $items = OrderItem::where('order_id', $this->order->id)->get();

        $this->order->update([
            'total'       => $items->sum('total'),
            'grand_total' => $items->sum('total') - $this->order->discount + $this->order->tax,
        ]);

       session()->flash('success', __('Order updated successfully'));

       $this->redirect('/dashboard/order/edit/' . $this->order->id, navigate: true);
    }
}
