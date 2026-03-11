<?php

namespace Database\Seeders\Admin;

use App\Models\Admin\Admin;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $admin =  Admin::create([
            'name'     => 'Admin',
            'email'    => 'admin@syntech.com',
            'password' => bcrypt('123456789')
        ]);

        $role = Role::first();

        $admin->addRole($role->id);
    }
}
