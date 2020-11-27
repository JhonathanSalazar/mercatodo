<?php

/** @var Factory $factory */


use App\Entities\Category;
use App\Entities\Product;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Category::class, function (Faker $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'url' => Str::slug($name)
    ];
});

$factory->afterCreating(Category::class, function ($category) {
    $category->products()->save(factory(Product::class)->make());
});
