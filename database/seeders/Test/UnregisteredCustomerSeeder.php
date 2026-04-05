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
                "name" => "unregistered customer 1",
                "phone" => "+966570640871",
                "email" => "unregister1@example.com",
                'points' => 5
            ]);


            
    }
}
