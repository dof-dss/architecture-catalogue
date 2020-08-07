<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\PersonalAccessToken;
use Faker\Generator as Faker;

$factory->define(PersonalAccessToken::class, function (Faker $faker) {
    return [
        'name' => $faker->text(30)
    ];
});
