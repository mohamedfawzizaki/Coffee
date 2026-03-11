<?php

namespace App\Livewire\Dashboard\Gift;

use App\Models\Order\Gift\GiftOrder;
use Livewire\Attributes\Title;
use Livewire\Component;

class GiftShow extends Component
{

    public $order;

    public function mount($id)
    {
        $this->order = GiftOrder::with(['items.product', 'items.size', 'branch', 'customer', 'sendTo', 'admin'])->findOrFail($id);
    }

    #[Title('Gift Details')]
    public function render()
    {
        return view('livewire.dashboard.gift.gift-show');
    }
}
