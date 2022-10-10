<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProjectCategory::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->uuid,
        'name' => $faker->word,
        'organization_id' => function (array $post) {
            return App\Models\Organization::inRandomOrder()->first()->id;
        }
    ];
});
