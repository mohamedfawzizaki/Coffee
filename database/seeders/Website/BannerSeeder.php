<?php

namespace Database\Seeders\Website;

use App\Models\Website\Banner\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

       for($i = 0; $i < 3; $i++){

        Banner::create([
            'ar_image' => $faker->imageUrl(),
            'en_image' => $faker->imageUrl(),
        ]);
    }
    }
}
