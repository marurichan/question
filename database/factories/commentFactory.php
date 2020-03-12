<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 4),
        'question_id' => $faker->numberBetween($min = 1, $max = 100),
        'comment' => $faker->realtext(30),
        'created_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
