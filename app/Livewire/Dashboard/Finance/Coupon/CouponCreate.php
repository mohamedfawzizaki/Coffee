<?php

namespace App\Livewire\Dashboard\Finance\Coupon;

use App\Models\Customer\Customer;
use App\Models\Finance\Coupon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

class CouponCreate extends Component
{
    public $code;
    public $type;
    public $amount;
    public $max_discount_amount;
    public $max_usage;
    public $max_usage_per_user;
    public $expire_date;
    public $min_order_amount;

    public $users;

    public $customers;

    public $customer_id;

    public function mount()
    {
        $this->users = 'all';

        $this->customers = Customer::all();
    }

    #[Title('Create Coupon')]
    public function render()
    {
        return view('livewire.dashboard.finance.coupon.coupon-create');
    }

    public function createCoupon()
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
            // 'customer_id'         => 'required_if:users,one|exists:customers,id',
         ]);

         Coupon::create($validated );

        session()->flash('success', __('Coupon created successfully'));

        $this->redirect('/dashboard/coupon', true);

    }
}

