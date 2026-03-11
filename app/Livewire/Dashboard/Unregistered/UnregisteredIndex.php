<?php

namespace App\Livewire\Dashboard\Unregistered;

use Livewire\Component;
use Livewire\Attributes\Title;

class UnregisteredIndex extends Component
{
    #[Title('Unregistered Customers')]
    public function render()
    {
        return view('livewire.dashboard.unregistered.unregistered-index');
    }
}
