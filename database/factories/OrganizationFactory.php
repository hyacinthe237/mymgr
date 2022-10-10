<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Organization::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->uuid,
        'name' => $faker->company,
        'official_name' => $faker->optional()->company,
        'address' => $faker->optional()->address,
        'phone' => $faker->optional()->e164PhoneNumber,
        'status' => $faker->randomElement(['active', 'suspended']),
        'admin_id' => function (array $post) {
            return App\Models\User::inRandomOrder()->first()->id;
        }
    ];
});
