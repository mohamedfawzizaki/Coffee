<?php

namespace App\Livewire\Dashboard\Order\Abandoned;

use Livewire\Attributes\Title;
use Livewire\Component;

class AbandonedIndex extends Component
{
    #[Title('Abandoned Orders')]
    public function render()
    {
        return view('livewire.dashboard.order.abandoned.abandoned-index');
    }
}
