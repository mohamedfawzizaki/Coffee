<?php

namespace App\Livewire\Dashboard\Branch;

use Livewire\Attributes\Title;
use Livewire\Component;

class BranchIndex extends Component
{
    #[Title('Branches')]
    public function render()
    {
        return view('livewire.dashboard.branch.branch-index');
    }
}
