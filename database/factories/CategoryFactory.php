<?php

/** @var Factory $factory */


use App\Entities\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->name;
    return [
        'name' => $name,
        'url' => \Illuminate\Support\Str::slug($name)
    ];
});
