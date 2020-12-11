<?php

/** @var Factory $factory */

use App\Entities\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {

    $name = $faker->firstName;

    return [
        'name' => $name,
        'url' => Str::slug($name)
    ];
});

