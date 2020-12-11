<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Constants\PaymentStatus;
use App\Entities\Order;
use App\Entities\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'order_reference' => Str::random(10),
        'user_id' => factory(App\Entities\User::class),
        'status' => PaymentStatus::PENDING,
        'grand_total' => $faker->randomNumber(7),
        'item_count' => $faker->randomNumber(2),
        'paid_at' => null,
        'payer_name' => $faker->name,
        'payer_email' => $faker->email,
        'document_type' => 'CC',
        'document_number' => $faker->randomNumber(7),
        'payer_phone' => $faker->phoneNumber,
        'payer_address' => $faker->address,
        'payer_city' => $faker->city,
        'payer_state' => $faker->state,
        'payer_postal' => $faker->postcode,
    ];
});

$factory->afterCreating(Order::class, function (Order $order, Faker $faker) {
    $product = factory(Product::class)->make();
    $order->items()->save($product, [
        'price' => $product->price,
        'quantity' => $faker->randomNumber(2),
    ]);
});
