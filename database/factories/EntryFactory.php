<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Entry;
use Faker\Generator as Faker;

$factory->define(Entry::class, function (Faker $faker) {
    return [
      'name' => $faker->sentence(2),
      'version' => (string) $faker->randomDigit(),
      'description' => $faker->sentence(10),
      'href' => $faker->url,
      'sub_category' => 'Other',
      'category' => 'Not categorised',
      'status' => 'evaluating',
      'functionality' => $faker->text(100),
      'service_levels' => $faker->text(100),
      'interfaces' => $faker->text(100),
    ];
});
