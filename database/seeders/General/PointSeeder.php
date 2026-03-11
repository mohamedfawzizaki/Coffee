<?php

namespace Database\Seeders\General;

use App\Models\Customer\Customer;
use App\Models\Customer\Point;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = \Faker\Factory::create();

        for($i = 0; $i < 10; $i++){

            Point::create([
                'customer_id' => Customer::all()->random()->id,
                'point'       => $faker->numberBetween(1, 100),
            ]);
        }
    }
}
