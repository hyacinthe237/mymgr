<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Project::class, function (Faker $faker) {
    return [
        'code' => $faker->unique()->uuid,
        'title' => $faker->catchPhrase,
        'description' => $faker->optional()->bs,
        'status' => $faker->randomElement(['pending','active','complete']),
        'goal' => $faker->optional()->text,
        'start_date' => $faker->optional()->dateTimeInInterval($startDate = '0 years', $interval = '+ 60 days', $timezone = null),
        'end_date' => $faker->optional()->dateTimeInInterval($startDate = '0 years', $interval = '+ 60 days', $timezone = null),
        'is_public' => $faker->randomElement(['0','1']),
        'owner_id' => function (array $post) {
            return App\Models\User::inRandomOrder()->first()->id;
        },
        'organization_id' => function (array $post) {
            return App\Models\Organization::inRandomOrder()->first()->id;
        },
        'category_id' => function (array $post) {
            return App\Models\ProjectCategory::inRandomOrder()->first()->id;
        },
        'created_by'  => function (array $post) {
            return App\Models\User::inRandomOrder()->first()->id;
        }
    ];
});
