<?php

/** @var Factory $factory */

use App\Entities\Report;
use App\Entities\User;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Report::class, function (Faker $faker) {
    return [
        'type' => $faker->firstName,
        'file_path' => $faker->url,
        'created_by' => factory(User::class)->create()->id,
    ];
});
