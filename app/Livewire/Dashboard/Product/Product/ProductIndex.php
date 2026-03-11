<?php

namespace App\Livewire\Dashboard\Product\Product;

use Livewire\Attributes\Title;
use Livewire\Component;

class ProductIndex extends Component
{
    #[Title('Products')]
    public function render()
    {
        return view('livewire.dashboard.product.product.product-index');
    }
}
