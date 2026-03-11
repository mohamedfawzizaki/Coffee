<?php

namespace App\Livewire\Dashboard\Order\Point;

use Livewire\Attributes\Title;
use Livewire\Component;

class PointOrderIndex extends Component
{
    #[Title('Point Orders')]
    public function render()
    {
        return view('livewire.dashboard.order.point.point-order-index');
    }
}
