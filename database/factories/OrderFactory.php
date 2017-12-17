<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'created_at' => $faker->dateTimeBetween('-5 years', '-1 month'),
        'updated_at' => $faker->dateTimeBetween('-5 years', '-1 month'),
        'in_process' => false,		
    ];
});
