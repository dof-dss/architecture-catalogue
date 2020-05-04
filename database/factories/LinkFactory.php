<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entry;
use App\Link;
use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
    return [
        'item1_id' => function () {
            return factory(Entry::class)->create()->id;
        },
        'item2_id' => function () {
            return factory(Entry::class)->create()->id;
        },
        'relationship' => 'composed_of'
    ];
});
