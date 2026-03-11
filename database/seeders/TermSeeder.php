<?php

namespace Database\Seeders;

use App\Models\General\Term;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Term::create([
        'ar' => [ 'content' => 'محتوى الموقع باللغة العربية',  ],
        'en' => [ 'content' => 'Content of the website in English', ],
       ]);
    }
}
