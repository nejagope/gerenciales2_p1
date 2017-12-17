<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
		'price' => $faker->randomFloat(2, 10, 1000),
		'image_url' => 'https://loremflickr.com/160/160?lock=' . rand(1, 3000),
		//'image_url' => 'http://lorempixel.com/160/160/technics/' . rand(1, 10),
		'description' => $faker->sentence,
    ];
});
