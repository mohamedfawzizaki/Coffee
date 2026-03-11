<?php

namespace App\Livewire\Dashboard\Product\Product;

use App\Models\Product\Product\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class ProductShow extends Component
{
    public $product;

    public function mount($id)
    {
        $this->product = Product::find($id);
    }

    #[Title('Product Details')]
    public function render()
    {
        return view('livewire.dashboard.product.product.product-show');
    }
}
