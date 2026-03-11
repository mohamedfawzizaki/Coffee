<?php

namespace App\Livewire\Dashboard\Report;


use App\Models\Order\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Carbon\Carbon;

class MonthOrderReport extends Component
{
   public $month;
   public $year;
   public $orders;
   public $days;
   public $chartData;


   protected $casts = [
       'month' => 'integer',
       'year'  => 'integer'
   ];

    public function mount()
    {
        $this->month = (int)date('n');
        $this->year = (int)date('Y');
        $this->fetchOrderData();
    }

    public function updatedMonth()
    {
        $this->month = (int)$this->month;

        $this->fetchOrderData();

        $this->dispatch('monthUpdated', month: $this->month);
    }

    public function updatedYear()
    {
        $this->year = (int)$this->year;

        $this->fetchOrderData();
    }

    // public function fetchOrderData()
    // {

    //     $daysInMonth = Carbon::createFromDate($this->year, $this->month, 1)->daysInMonth;


    //     $this->days = collect(range(1, $daysInMonth))->mapWithKeys(function ($day) {
    //         return [$day => 0];
    //     });

    //         foreach ($this->days as $day => $count) {

    //             $orderCounts = Order::whereRaw('DAY(created_at) = ?', [$day])
    //             ->whereYear('created_at', $this->year)
    //             ->count();

    //             $this->days[$day] = $orderCounts;
    //         }

    //     $this->prepareChartData();
    // }

    public function fetchOrderData()
{
    $daysInMonth = Carbon::createFromDate($this->year, $this->month, 1)->daysInMonth;
    
    $this->days = collect(range(1, $daysInMonth))->mapWithKeys(function ($day) {
        return [$day => 0];
    });

    // استخدام whereBetween أو whereMonth
    foreach ($this->days as $day => $count) {
        $startOfDay = Carbon::createFromDate($this->year, $this->month, $day)->startOfDay();
        $endOfDay = Carbon::createFromDate($this->year, $this->month, $day)->endOfDay();
        
        $orderCounts = Order::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->count();
        
        $this->days[$day] = $orderCounts;
    }
    
    $this->prepareChartData();
}

    private function prepareChartData()
    {

        $data = $this->days->values()->toArray();

        $categories = $this->days->keys()->map(function($day) {

            return (string) $day;

        })->toArray();

        $this->chartData = [
            'series' => [
                [
                    'name' => 'Orders',
                    'data' => $data
                ]
            ],
            'categories' => $categories
        ];

        $this->dispatch('chartDataUpdated', chartData: $this->chartData);
    }

    #[Title('Month Orders Report')]
    public function render()
    {
        return view('livewire.dashboard.report.month-report', [
            'chartData' => $this->chartData
        ]);
    }
}
