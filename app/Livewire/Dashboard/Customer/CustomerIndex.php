<?php

namespace App\Livewire\Dashboard\Customer;

use App\Livewire\Dashboard\Customer\CustomerTable;
use Livewire\Attributes\Title;
use Livewire\Component;

class CustomerIndex extends Component
{
    #[Title('Customers')]
    public function render()
    {

        return view('livewire.dashboard.customer.customer-index');
    }

    public function show($customer)
    {
        dd($customer);
    }
}
