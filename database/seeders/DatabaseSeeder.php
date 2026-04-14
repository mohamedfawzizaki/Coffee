<?php

namespace Database\Seeders;

use App\Models\Customer\UnregisteredCustomer;
use App\Models\User;
use Database\Seeders\Admin\AdminSeeder;
use Database\Seeders\Customer\CustomerCardSeeder;
use Database\Seeders\Customer\CustomerSeeder;
use Database\Seeders\General\BranchSeeder;
use Database\Seeders\General\PointSeeder;
use Database\Seeders\General\SettingSeeder;
use Database\Seeders\General\WorktimeSeeder;
use Database\Seeders\Gift\GiftSeeder;
use Database\Seeders\Order\OrderSeeder;
use Database\Seeders\Product\ProductSeeder;
use Database\Seeders\Website\BannerSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // CustomerSeeder::class,
            // LaratrustSeeder::class,
            // AdminSeeder::class,
            // SettingSeeder::class,
            BranchSeeder::class,
            WorktimeSeeder::class,
            ProductSeeder::class,
            GiftSeeder::class,
            CustomerCardSeeder::class,
            BannerSeeder::class,
            PointSeeder::class,
            // TermSeeder::class,
            
            
            
            // \Database\Seeders\Test\CustomerCardSeeder::class,
            // \Database\Seeders\Test\UnregisteredCustomerSeeder::class,
            // \Database\Seeders\Test\CustomerSeeder::class,
            // \Database\Seeders\Test\PaymentSeeder::class,
            OrderSeeder::class,
            \Database\Seeders\Test\ContactSeeder::class,
            \Database\Seeders\Test\GiftTestSeeder::class,
            
        ]);
    }
}
