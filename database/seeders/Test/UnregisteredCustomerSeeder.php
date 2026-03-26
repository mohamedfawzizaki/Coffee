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
                "name" => "test unregistered customer 2",
                "phone" => "01234567891",
                "email" => "unregistered2@example.com",
                'points' => 5
            ]);


            
    }
}
