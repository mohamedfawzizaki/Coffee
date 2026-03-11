<?php

namespace App\Livewire\Dashboard\Payment;

use App\Models\Finance\Payment;
use Livewire\Attributes\Title;
use Livewire\Component;

class PaymentIndex extends Component
{
    public $today;

    public $month;

    public $total;

    public function mount()
    {
        $today = now();
        $this->today = Payment::whereDate('created_at', $today->toDateString())->sum('amount');
        $this->month = Payment::whereYear('created_at', $today->year)
                              ->whereMonth('created_at', $today->month)
                              ->sum('amount');
        $this->total = Payment::sum('amount');
    }

    #[Title('Payments')]
    public function render()
    {
        return view('livewire.dashboard.payment.payment-index');
    }
}
