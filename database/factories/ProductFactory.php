<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

$factory->define(Product::class, function (Faker $faker) {

    $filepath = storage_path('app/public/images');

    if (!File::exists($filepath)) {
        File::makeDirectory($filepath);
    }

    return [
        'user_id' =>  factory(App\Models\User::class),
        'name' => $faker->firstName,
        'ean' => $faker->randomNumber(8),
        'branch' => $faker->lastName,
        'description' => $faker->paragraph,
        'price' => $faker->randomNumber(3) * 100,
        //'image' => 'images/' . $faker->image('storage/app/public/images',250 ,250, null, false),
        'published_at' => Carbon::yesterday()
    ];
});
