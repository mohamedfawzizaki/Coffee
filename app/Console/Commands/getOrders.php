<?php

namespace App\Console\Commands;

use App\Service\Foodics\FoodicsService;
use Illuminate\Console\Command;

class getOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-orders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch orders from Foodics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $foodicsService = new FoodicsService();

        $orders =  $foodicsService->getOrders();
    }
}
