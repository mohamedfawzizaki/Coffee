<?php

namespace App\Livewire\Dashboard\GiftTransfer;

use Livewire\Attributes\Title;
use Livewire\Component;

class GiftTransferIndex extends Component
{
    #[Title('Gifts Transfers')]
    public function render()
    {
        return view('livewire.dashboard.gift-transfer.gift-transfer-index');
    }
}
