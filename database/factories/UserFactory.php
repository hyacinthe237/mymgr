<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$now = Carbon::now()->format('Y-m-d H:i:s');

$factory->define(User::class, function (Faker $faker) use ($now) {
    return [
        'card_last_digits'  => '9876',
        'date_of_birth'     => $faker->randomElement(['2002-02-19', '1995-11-22', '1987-06-30', '1978-07-13']),
        'card_expiry'       => '11/22',
        'country_id'        => 1,
        'created_at'        => $now,
        'updated_at'        => $now,
        'api_token'         => Str::random(77),
        'firstname'         => $faker->firstName,
        'lastname'          => $faker->lastName,
        'username'          => $faker->unique()->userName,
        'postcode'          => '2000',
        'password'          => bcrypt('secret'),
        'ratings'           => $faker->randomElement([3.8, 3.9, 4.0, 4.1, 4.5, 4.6, 4.7, 4.8, 4.9, 5]),
        'address'           => $faker->streetAddress,
        'role_id'           => $faker->numberBetween(2,3),
        'suburb'            => $faker->randomElement(['Sydney', 'Mortdale', 'Hurstville', 'Parramatta', 'Liverpool', 'Ryde', 'North Sydney', 'Cronulla', 'Ashfield', 'Richmond', 'Redfern', 'Ultimo']),
        'status'            => $faker->randomElement(['active', 'active', 'active', 'pending']),
        'mobile'            => $faker->e164PhoneNumber,
        'state'             => $faker->randomElement(['nsw', 'nsw', 'nsw', 'act', 'qld', 'nt']),
        'email'             => $faker->unique()->email,
        'code'              => $faker->uuid,
        'sex'               => $faker->randomElement(['Female', 'Male', 'Other']),
        'pin'               => $faker->randomElement([100001, 999999])
    ];
});
