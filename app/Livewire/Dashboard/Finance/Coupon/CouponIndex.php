<?php

namespace App\Livewire\Dashboard\Finance\Coupon;

use Livewire\Attributes\Title;
use Livewire\Component;

class CouponIndex extends Component
{
    #[Title('Coupons')]
    public function render()
    {
        return view('livewire.dashboard.finance.coupon.coupon-index');
    }
}
