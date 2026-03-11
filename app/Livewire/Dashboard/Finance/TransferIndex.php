<?php

namespace App\Livewire\Dashboard\Finance;

use Livewire\Attributes\Title;
use Livewire\Component;

class TransferIndex extends Component
{
    #[Title('Transfers')]
    public function render()
    {
        return view('livewire.dashboard.finance.transfer-index');
    }
}
