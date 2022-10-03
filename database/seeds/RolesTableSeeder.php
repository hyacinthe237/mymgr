<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin', 'display_name' => 'Admin']);
        Role::create(['name' => 'chef', 'display_name' => 'Chef']);
        Role::create(['name' => 'customer', 'display_name' => 'Customer']);
    }
}
