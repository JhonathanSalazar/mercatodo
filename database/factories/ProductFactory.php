<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'user_id' => auth()->id() ? auth()->id() : '1',
        'name' => $faker->firstName,
        'ean' => $faker->randomNumber(8),
        'branch' => $faker->lastName,
        'description' => $faker->paragraph,
        'price' => $faker->randomNumber(3) * 100,
    ];
});
