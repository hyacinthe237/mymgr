<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
             'code' => '05d3df40-7952-11e8-844c-d9777b6f949c',
             'firstname' => 'MyMgr',
             'lastname' => 'Admin',
             'email' => 'admin@mymgr.cm',
             'password' => bcrypt('secret'),
             'phone' => '+237698196943',
             'api_token' => str_random(60),
             'status' => 'active',
             'photo' => 'https://image.freepik.com/free-icon/profile-user-silhouette_318-40557.jpg',
             'dob' => '2018-08-05',
             'gender' => 'male'
         ]);

       factory(App\Models\User::class, 20)->create();


    }
}
