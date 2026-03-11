<?php

namespace Database\Seeders\General;

use App\Models\Branch\Branch;
use App\Models\Branch\Worktime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorktimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        foreach(Branch::all() as $branch){

        for($i = 0; $i < 3; $i++){

            Worktime::create([
                'day'       => $faker->dayOfWeek(),
                'from'      => $faker->time(),
                'to'        => $faker->time(),
                'branch_id' => $branch->id,
            ]);
        }
    }
}

}
