<?php

namespace App\Livewire\Dashboard\PosManger;

use Livewire\Attributes\Title;
use Livewire\Component;

class PosMangerIndex extends Component
{
    #[Title('Pos Manager')]
    public function render()
    {
        return view('livewire.dashboard.pos-manger.pos-manger-index');
    }
}
