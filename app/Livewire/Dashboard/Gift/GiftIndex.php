<?php

namespace App\Livewire\Dashboard\Gift;

use Livewire\Attributes\Title;
use Livewire\Component;

class GiftIndex extends Component
{
    #[Title('Gifts')]
    public function render()
    {
        return view('livewire.dashboard.gift.gift-index');
    }
}
