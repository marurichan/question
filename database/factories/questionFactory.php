<?php

use Faker\Generator as Faker;
use App\Models\Question;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween(1, 4),
        'tag_category_id' => $faker->numberBetween(1, 4),
        'title' => $faker->realtext(30),
        'content' => $faker->realtext(50),
        'created_at' => $faker->dateTime('now', date_default_timezone_get()),
    ];
});
