<?php

namespace App\Livewire\Dashboard\Order;

use Livewire\Attributes\Title;
use Livewire\Component;

class OrderIndex extends Component
{
    #[Title('Orders')]
    public function render()
    {
        return view('livewire.dashboard.order.product-order-index');
    }
}
