<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Ticket::class, function (Faker $faker) {
    return [
        'status' => 1,
        'title' => $faker->catchPhrase,
        'description' => $faker->optional()->bs,
        'priority' => $faker->randomElement(['low','medium','high','critical']),
        'complexity' => $faker->randomElement(['low','medium','high','critical']),
        'project_id' => function (array $post) {
            return App\Models\Project::inRandomOrder()->first()->id;
        },
        'created_by' => function (array $post) {
            return App\Models\User::inRandomOrder()->first()->id;
        },
        'parent_id' => function (array $post) {
        	$ticket=App\Models\Ticket::inRandomOrder()->first();
        	if($ticket)
            	return $ticket->id;
            else
            	return null;
        },
        'assignee_id' => function (array $post) {
            return App\Models\User::inRandomOrder()->first()->id;
        },
        'number' => $faker->unique()->randomNumber,
        'start_date' => $faker->optional()->dateTimeInInterval($startDate = '0 years', $interval = '+ 60 days', $timezone = null),
        'end_date' => $faker->optional()->dateTimeInInterval($startDate = '0 years', $interval = '+ 60 days', $timezone = null),
        'estimate' => $faker->optional()->randomDigitNotNull
    ];
});
