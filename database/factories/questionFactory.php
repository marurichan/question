<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Question::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 4),
        'tag_category_id' => $faker->numberBetween($min = 1, $max = 4),
        'title' => $faker->realtext(30),
        'content' => $faker->realtext(50),
        'created_at' => $faker->dateTime($max = 'now', $timezone = date_default_timezone_get()),
    ];
});
