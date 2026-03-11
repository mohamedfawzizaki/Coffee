<?php

namespace App\Livewire\Dashboard\GiftTransfer;

use App\Models\Gift\Gift;
use Livewire\Attributes\Title;
use Livewire\Component;

class GiftTransferShow extends Component
{
    public $gift;

    public function mount($id)
    {
        $this->gift = Gift::with(['sender', 'receiver'])->findOrFail($id);
    }

    #[Title('Gift Transfer Details')]
    public function render()
    {
        return view('livewire.dashboard.gift-transfer.gift-transfer-show');
    }
}
