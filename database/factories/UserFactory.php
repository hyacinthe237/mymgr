<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->uuid,
        'firstname' => $faker->firstName,
        'lastname' => $faker->optional()->lastName,
        'email' => $faker->unique()->email,
        'password' => bcrypt('secret'), // secret,
        'phone' => $faker->optional()->e164PhoneNumber,
        'api_token' => $faker->unique()->md5,
        'status' => $faker->randomElement(['pending' ,'active', 'blocked']),
        'photo' => 'https://image.freepik.com/free-icon/profile-user-silhouette_318-40557.jpg',
        'dob' => $faker->optional()->dateTimeInInterval($startDate = '0 years', $interval = '+ 60 days', $timezone = null),
        'gender' =>$faker->randomElement(['male' ,'female'])
    ];
});
