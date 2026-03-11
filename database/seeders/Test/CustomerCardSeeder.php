<?php

namespace Database\Seeders\Test;

use App\Models\CustomerCard\CustomerCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        for($i = 0; $i < 3; $i++){

            CustomerCard::create([
                'ar'    => ['title' => 'Card ' . ($i + 1)],
                'en'    => ['title' => 'Card ' . ($i + 1)],
                'image' => $faker->imageUrl(),
                'money_to_point' => $faker->numberBetween(1, 100),
                'point_to_money' => $faker->numberBetween(1, 100),
                'content' => $faker->sentence(),
                'orders_count' => $faker->numberBetween(1, 100),
            ]);

        }
    }
}
