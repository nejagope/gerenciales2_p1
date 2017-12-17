<?php

use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'created_at' => $faker->dateTimeBetween('-5 days', 'now'),
        'updated_at' => $faker->dateTimeBetween('-5 days', 'now'),
        'question' => $faker->sentence,	
    ];
});
