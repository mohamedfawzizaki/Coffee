<?php

namespace App\Livewire\Dashboard\Point;

use Livewire\Attributes\Title;
use Livewire\Component;

class PointIndex extends Component
{
    #[Title('Points')]
    public function render()
    {
        return view('livewire.dashboard.point.point-index');
    }
}
