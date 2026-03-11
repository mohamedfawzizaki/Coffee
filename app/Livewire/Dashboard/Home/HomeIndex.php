<?php

namespace App\Livewire\Dashboard\Home;

use App\Models\Customer\Customer;
use App\Models\Order\Order;
use App\Models\Order\ProductOrder;
use App\Models\Product\Product\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

class HomeIndex extends Component
{
     public $customers;

     public $orders;

     public $gifts;

     public $payments;

     public $latest_customers;

     public $best_selling_products;

     public $latest_orders;

     public $latest_gifts;

     public $months = [];

     public $ordersChart;

    public function mount(){

        $this->customers = Customer::count();

        $this->orders    = Order::where('type', 'order')->count();

        $this->gifts     = Order::where('type', 'gift')->count();

        $this->latest_customers = Customer::latest()->take(5)->get();

        $this->best_selling_products = Product::withCount('orders')->with('orders')->orderBy('orders_count', 'desc')->take(5)->get();

        $this->latest_orders = Order::where('type', 'order')->latest()->take(5)->get();

        $this->latest_gifts = Order::where('type', 'gift')->latest()->take(5)->get();

        $this->months = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];


          foreach ($this->months as $month) {
            $this->ordersChart[] =   Order::where('type', 'order')->whereMonth('created_at', date('m', strtotime($month)))->count();
          }


    }

    #[Title('Dashboard')]
    public function render()
    {

        return view('livewire.dashboard.home.home-index');
    }
}
