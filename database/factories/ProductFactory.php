<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

$factory->define(Product::class, function (Faker $faker) {

    $filepath = storage_path('app/public/images');

    if (!File::exists($filepath)) {
        File::makeDirectory($filepath);
    }

    return [
        'user_id' =>  factory(App\Entities\User::class),
        'name' => $faker->firstName,
        'ean' => $faker->randomNumber(8),
        'branch' => $faker->lastName,
        'description' => $faker->paragraph,
        'price' => $faker->randomNumber(3) * 100,
        'image' => 'images/default.jpg',
        'published_at' => Carbon::yesterday()
    ];
});
