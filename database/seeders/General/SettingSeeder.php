<?php

namespace Database\Seeders\General;

use App\Models\General\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        Setting::create([
            'title'       => 'syntech',
            'logo'        =>  $faker->imageUrl(),
            'favicon'     =>  $faker->imageUrl(),
            'email'       =>  $faker->email(),
            'phone'       =>  $faker->phoneNumber(),
            'whatsapp'    =>  $faker->phoneNumber(),
            'address'     =>  $faker->address(),
        ]);
    }
}
