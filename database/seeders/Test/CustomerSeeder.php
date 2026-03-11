<?php

namespace Database\Seeders\Test;

use App\Models\Customer\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Customer\Customer::create([
                "name" => "ahmed",
                "phone" => "0123434575",
                "email" => "ahmed@example.com",
            ]);


            
    }
}
