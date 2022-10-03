<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $users = [
            [
                'card_last_digits'  => '3856',
                'date_of_birth'     => '1995-03-19',
                'card_expiry'       => '11/22',
                'country_id'        => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
                'api_token'         => \Str::random(128),
                'firstname'         => 'Admin',
                'username'          => 'izytech',
                'lastname'          => 'Joe',
                'postcode'          => '2233',
                'password'          => bcrypt('s3kr37Yum'),
                'ratings'           => 5,
                'address'           => '19 Eddy avenue',
                'role_id'           => 1,
                'suburb'            => 'Sydney',
                'status'            => 'active',
                'mobile'            => '0422942033',
                'state'             => 'nsw',
                'email'             => 'eddy@izytechgroup.com',
                'code'              => '91f8f449-be23-49e0-8476-317f9697914f',
                'pin'               =>  987123,
                'sex'               =>  'Male',
            ],

            [
                'card_last_digits'  => '9876',
                'date_of_birth'     => '2002-02-19',
                'card_expiry'       => '11/22',
                'country_id'        => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
                'api_token'         => 'Jy8E8Sw8bhSUa2qaWwfckVxQxouDnVuSmLhpiRcbVW3XOAnab7tTBnNmLqnH5CjPwrnzpPJ9qZFTZo83WmcU1a4AdtyX0u5eTbzjcEsKWpJxC7uwxUkbTvwoC65CcS53',
                'firstname'         => 'John',
                'username'          => 'testuser',
                'lastname'          => 'Doe',
                'postcode'          => '2000',
                'password'          => bcrypt('secret'),
                'ratings'           => 5,
                'address'           => '17 Eddy avenue',
                'role_id'           => 3,
                'suburb'            => 'Sydney',
                'status'            => 'pending',
                'mobile'            => '0422942032',
                'state'             => 'nsw',
                'email'             => 'eddy.insearch@gmail.com',
                'code'              => '47477760-59ba-11eb-9222-fbe4163e8823',
                'pin'               =>  139253,
                'sex'               =>  'Male',
            ],

            [
                'card_last_digits'  => '9876',
                'date_of_birth'     => '2002-02-19',
                'card_expiry'       => '11/22',
                'country_id'        => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
                'api_token'         => 'As9B6Kt2ihSUa2waWqfckVxQxouonVuSmLhKiRcbxW3XOAnab7pTBnNmLqnH5CjPwrnzpPJ9qZFTZo83WmcU1a4AdtyX0u5eTbzjcEsKWpJxC7uwxUkbTvwoC65CcS53',
                'firstname'         => 'Jane',
                'username'          => 'testchef',
                'lastname'          => 'Doe',
                'postcode'          => '2000',
                'password'          => bcrypt('secret'),
                'ratings'           => 5,
                'address'           => '7 Eddy avenue',
                'role_id'           => 2,
                'suburb'            => 'Sydney',
                'status'            => 'active',
                'mobile'            => '0422942033',
                'state'             => 'nsw',
                'email'             => 'eddy.insearch+chef@gmail.com',
                'code'              => 'e59028ca-c39b-4435-acbc-d078f3afc14d',
                'sex'               =>  'Female',
                'pin'               =>  102030,
            ]
        ];

        DB::table('users')->insert($users);

        factory(App\Models\User::class, 200)->create();
    }
}
