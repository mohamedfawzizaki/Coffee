<?php

namespace App\Livewire\Dashboard\Report;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use App\Notifications\Admin\MarketingNotification;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Collection;

class CustomerOrderReport extends Component
{
    public $type = 'has_orders';
    public $from;
    public $to;
    public $customers;
    public $notificationTitle = '';
    public $notificationContent = '';

    public function mount()
    {
        $this->customers = collect();
    }

    #[Title('Customer Orders Report')]
    public function render()
    {
        return view('livewire.dashboard.report.customer-order-report');
    }

    public function generateReport()
    {
        $query = Customer::query();

        if ($this->type == 'has_orders') {
            $query->whereHas('orders', function($query) {
                if ($this->from) {
                    $query->where('created_at', '>=', $this->from);
                }
                if ($this->to) {
                    $query->where('created_at', '<=', $this->to);
                }
            });
        }

        if ($this->type == 'no_orders') {
            $query->whereDoesntHave('orders', function($query) {
                if ($this->from) {
                    $query->where('created_at', '>=', $this->from);
                }
                if ($this->to) {
                    $query->where('created_at', '<=', $this->to);
                }
            });
        }

        $this->customers = $query->withCount('orders')->get();
        $this->dispatch('customers-generated', customers: $this->customers);
    }

    public function sendNotification()
    {
        $this->validate([
            'notificationTitle' => 'required|min:3',
            'notificationContent' => 'required|min:10',
        ]);


        foreach ($this->customers as $customer) {

         $customer->notify(new MarketingNotification($this->notificationTitle, $this->notificationContent));
        }

        request()->session()->flash('success', __('Notification sent successfully'));

        $this->dispatch('notification-sent');

        // Reset the form
        $this->notificationTitle = '';
        $this->notificationContent = '';
    }
}
