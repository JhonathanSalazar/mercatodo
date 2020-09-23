<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use App\Product;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'order_reference' => $faker->uuid,
        'user_id' => factory(App\User::class),
        'status' => 'pending',
        'grand_total' => $faker->randomNumber(7),
        'item_count' => $faker->randomNumber(2),
        'is_paid' => false,
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

