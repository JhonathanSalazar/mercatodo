<?php

namespace Tests\Feature\Orders;

use App\Order;
use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateOrderTest extends TestCase
{

    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function aBuyerCanUpdateYourOrder()
    {

        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $order = factory(Order::class)->create([
            'user_id' => $buyerUser
        ]);

        $payer_name = $this->faker->name;
        $payer_email = $this->faker->email;
        $document_number = $this->faker->randomNumber(8);
        $payer_phone = $this->faker->phoneNumber;
        $payer_address = $this->faker->address;
        $payer_city = $this->faker->city;
        $payer_state = $this->faker->state;
        $payer_postal = $this->faker->postcode;

        $order->payer_name = $payer_name;
        $order->payer_email = $payer_email;
        $order->document_number = $document_number;
        $order->payer_phone = $payer_phone;
        $order->payer_address = $payer_address;
        $order->payer_city = $payer_city;
        $order->payer_state = $payer_state;
        $order->payer_postal = $payer_postal;

        $this->put(route('orders.update', $order));

        $order->fresh();

        $this->assertEquals($order->payer_name, $payer_name);
        $this->assertEquals($order->payer_email, $payer_email);
        $this->assertEquals($order->document_number, $document_number);
        $this->assertEquals($order->payer_phone, $payer_phone);
        $this->assertEquals($order->payer_address, $payer_address);
        $this->assertEquals($order->payer_city, $payer_city);
        $this->assertEquals($order->payer_state, $payer_state);
        $this->assertEquals($order->payer_postal, $payer_postal);
    }
}
