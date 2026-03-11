<?php

namespace App\Livewire\Dashboard\CustomerCard;

use Livewire\Attributes\Title;
use Livewire\Component;

class CustomerCardIndex extends Component
{
    #[Title('Customers Cards')]
    public function render()
    {
        return view('livewire.dashboard.customer-card.customer-card-index');
    }
}
