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
                "name" => "Mohamed Fawzi",
                "phone" => "01234567890",
                "email" => "mohamed@example.com",
                'points' => 5
            ]);


            
    }
}
