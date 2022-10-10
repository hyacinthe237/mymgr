<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Invitation::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->uuid,
        'messsage' => $faker->catchPhrase,
        'status' => $faker->randomElement(['pending', 'accepted', 'denied']),
        'firstname' => $faker->firstName,
        'lastname' => $faker->optional()->lastName,
        'email' => $faker->unique()->email,
        'phone' => $faker->optional()->e164PhoneNumber,
        'sent_by' => function (array $post) {
            return App\Models\User::inRandomOrder()->first()->id;
        },
        'organization_id' => function (array $post) {
            return App\Models\Organization::inRandomOrder()->first()->id;
        }
    ];
});
