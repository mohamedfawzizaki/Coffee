<?php

namespace Database\Seeders\General;

use Illuminate\Database\Seeder;


use Faker\Factory as Faker;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // try {

        //  $this->command->call('get-branches');

        // $faker = \Faker\Factory::create();

        // foreach(Branch::all() as $branch){

        //     BranchManager::create([
        //         'branch_id' => $branch->id,
        //         'name' => $faker->name(),
        //         'email' => $faker->email(),
        //         'phone' => $faker->phoneNumber(),
        //         'password' => bcrypt('123456789'),
        //         'image' => $faker->imageUrl(),
        //     ]);
        // }
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }

        $faker = Faker::create();

        // Example: create 10 branches
        for ($i = 0; $i < 10; $i++) {
            \Illuminate\Support\Facades\DB::table('branches')->insert([
                'address'   => $faker->address,
                'lat'       => $faker->latitude,
                'lng'       => $faker->longitude,
                'phone'     => $faker->phoneNumber,
                'email'     => $faker->unique()->safeEmail,
                'image'     => '',
                'status'    => $faker->boolean(80), // 80% chance to be true
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);
        }


    }
}
