<?php

namespace App\Livewire\Dashboard\Order\Point;

use App\Livewire\Dashboard\Order\OrderShow;
use Livewire\Attributes\Title;

class PointOrderShow extends OrderShow
{
    #[Title('Point Order Details')]
    public function render()
    {
        return view('livewire.dashboard.order.point.point-order-show');
    }

    public function updateStatus()
    {
        $this->order->status = $this->status;

        $this->order->save();

        $customer = $this->order->customer;

        $customer->notify(new \App\Notifications\Admin\OrderStatusNotification($this->status));

        request()->session()->flash('success', __('Status updated successfully'));

        return $this->redirect('/dashboard/pointorder/show/' . $this->order->id, navigate: true);
    }
}
