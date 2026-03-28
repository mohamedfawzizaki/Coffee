<?php

namespace Database\Seeders\Test;

use App\Models\Customer\Customer;
use Illuminate\Database\Seeder;

class UnregisteredCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Customer\UnregisteredCustomer::create([
                "name" => "test unregistered customer 10",
                "phone" => "+966570640878",
                "email" => "unregistered10@example.com",
                'points' => 5
            ]);


            
    }
}
