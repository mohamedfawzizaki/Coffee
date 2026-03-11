<?php

namespace Database\Seeders\Customer;

use App\Models\Customer\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 30; $i++) {

            Customer::create([
                 'name'       => $faker->name(),
                 'email'      => $faker->email(),
                 'phone'      => $faker->phoneNumber(),
                 'birthday'   => $faker->date(),
            ]);

        }
    }
}
