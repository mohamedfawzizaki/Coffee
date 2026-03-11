<?php

namespace App\Livewire\Dashboard\Finance\Coupon;

use App\Models\Finance\Coupon;
use Livewire\Component;

class CouponEdit extends Component
{
    public $code;
    public $type;
    public $amount;
    public $max_discount_amount;
    public $max_usage;
    public $max_usage_per_user;
    public $expire_date;
    public $min_order_amount;
    public $coupon;

    public function mount($id)
    {
        $this->coupon = Coupon::find($id);
        $this->code = $this->coupon->code;
        $this->type = $this->coupon->type;
        $this->amount = $this->coupon->amount;
        $this->max_discount_amount = $this->coupon->max_discount_amount;
        $this->max_usage = $this->coupon->max_usage;
        $this->max_usage_per_user = $this->coupon->max_usage_per_user;
        $this->expire_date = $this->coupon->expire_date;
        $this->min_order_amount = $this->coupon->min_order_amount;
    }

    public function render()
    {
        return view('livewire.dashboard.finance.coupon.coupon-edit');
    }

    public function updateCoupon()
    {
        $validated = $this->validate([
            'code'                => 'required|string|max:255',
            'type'                => 'required|string|in:fixed,percentage',
            'amount'              => 'required|numeric|min:1|max:100',
            'max_discount_amount' => 'required|numeric|min:1',
            'max_usage'           => 'required|numeric|min:1',
            'max_usage_per_user'  => 'required|numeric|min:1',
            'expire_date'         => 'required|date|after:today',
            'min_order_amount'    => 'required|numeric|min:1',
        ]);

        $this->coupon->update($validated);

        session()->flash('success', __('Coupon updated successfully'));

        $this->redirect('/dashboard/coupon', true);
    }
}
