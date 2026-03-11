<?php

namespace App\Livewire\Dashboard\Report;

use App\Models\Branch\Branch;
use App\Models\Customer\Customer;
use App\Models\Location\Region;
use App\Models\Order\Order;
use App\Models\Product\Brand\Brand;
use App\Models\Product\Category\PCategory;
use App\Models\Product\Product\Product;
use App\Models\Product\Subcategory\Subcategory;
use Livewire\Attributes\Title;
use Livewire\Component;


class ReportInbdex extends Component
{
    public $topProducts;

    public $topCustomers;

    public $topRegions;

    public $topCategories;

    public $orders;

    public $branchOrders;

    public $months;

    public $chartData;

    public $year = '2025';

    protected $casts = [
        'year' => 'integer'
    ];

    public $totalProducts;

    public $totalSales;

    public $netProfit;

    public $totalCustomers;

    public $basicCustomers;

    public $silverCustomers;

    public $goldCustomers;

    public $totalOrdersCount;

    public $giftProductsTotal;

    public $giftCardsTotal;

    public function updatedYear()
    {
        $this->year = (int)$this->year;
        $this->refreshChartData();
        $this->dispatch('chartDataUpdated', chartData: $this->chartData);
    }

    private function refreshChartData()
    {
        $this->chartData = [];

        foreach ($this->months as $month) {
            $this->chartData[$month] = Order::whereYear('created_at', $this->year)
                ->whereMonth('created_at', date('m', strtotime($month)))
                ->where('status', 'completed')
                ->count();
        }
    }

    public function mount()
    {
        // Top Products by sales count
        $this->topProducts = Product::withCount(['orders' => function($query) {
            $query->where('status', 'completed');
        }])->orderBy('orders_count', 'desc')->limit(5)->get();

        // Top Customers by order count
        $this->topCustomers = Customer::withCount(['orders' => function($query) {
            $query->where('status', 'completed');
        }])->orderBy('orders_count', 'desc')->limit(5)->get();

        // Top Categories
        $this->topCategories = PCategory::withCount(['products' => function($query) {
            $query->withCount(['orders' => function($q) {
                $q->where('status', 'completed');
            }]);
        }])->orderBy('products_count', 'desc')->limit(5)->get();

        // Branch Statistics - Sorted by Net Sales
        $this->branchOrders = Branch::withCount(['orders' => function($query) {
            $query->where('status', 'completed');
        }])
        ->withSum(['orders' => function($query) {
            $query->where('status', 'completed');
        }], 'grand_total')
        ->orderBy('orders_sum_grand_total', 'desc')
        ->get();

        // Financial Metrics
        $this->totalProducts    = Product::count();
        $this->totalOrdersCount = Order::where('status', 'completed')->count();
        $this->totalSales       = Order::where('status', 'completed')->sum('grand_total');
        
        $totalCost = \App\Models\Order\OrderItem::whereHas('order', function($query) {
            $query->where('status', 'completed');
        })->select(\Illuminate\Support\Facades\DB::raw('SUM(cost_price * quantity) as total_cost'))->value('total_cost') ?? 0;

        $giftCost = \App\Models\Order\Gift\GiftOrderItem::whereHas('order', function($query) {
            // Assuming gift orders are always 'paid' and effectively 'completed' for profit
            $query->where('payment_status', 'paid');
        })->select(\Illuminate\Support\Facades\DB::raw('SUM(cost_price * quantity) as total_cost'))->value('total_cost') ?? 0;

        $this->netProfit = $this->totalSales - ($totalCost + $giftCost);

        // Customer Metrics
        $this->totalCustomers = Customer::count();
        $this->basicCustomers = Customer::where('card_id', 1)->count();
        $this->silverCustomers = Customer::where('card_id', 2)->count();
        $this->goldCustomers = Customer::where('card_id', 3)->count();

        // Gift Metrics
        $this->giftProductsTotal = \App\Models\Order\Gift\GiftOrder::sum('grand_total');
        $this->giftCardsTotal    = \App\Models\Gift\Gift::sum('amount');

        $this->orders = Order::where('status', 'completed')->get();

        $this->months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];

        $this->refreshChartData();
    }

    #[Title('Report')]
    public function render()
    {
        return view('livewire.dashboard.report.report-inbdex');
    }
}
