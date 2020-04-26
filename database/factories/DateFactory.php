<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Date;
use Faker\Generator as Faker;

$factory->define(Date::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween('next Monday', 'next Monday +7 days'),
    ];
});
