<?php

namespace Tests\Feature\Orders;

use App\Order;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ShowOrderTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function aGuestCantShowOrders()
    {

        $order = factory(Order::class)->create();

        $this->get(route('order.show', compact('order')))
            ->assertRedirect(route('login'));

    }

    /**
     * @test
     */
    public function aAdminCantShowOrders()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $order = factory(Order::class)->create();

        $this->get(route('order.show', compact('order')))
            ->assertStatus(403);

    }

    /**
     * @test
     */
    public function aBuyerCanShowYourOrders()
    {
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $order = factory(Order::class)->create([
            'user_id' => $buyerUser
        ]);

        $productOrder = $order->items()->get()[0];

        $response = $this->get(route('order.show', compact('order')));

        $response->assertStatus(200)
            ->assertSee($productOrder->name)
            ->assertSee($productOrder->pivot->quantity)
            ->assertSee($productOrder->pivot->price)
            ->assertSee($order->payer_name)
            ->assertSee($order->ayer_email)
            ->assertSee($order->document_number)
            ->assertSee($order->payer_phone)
            ->assertSee($order->payer_address)
            ->assertSee($order->payer_city)
            ->assertSee($order->payer_state)
            ->assertSee($order->payer_postal);

    }

    /**
     * @test
     */
    public function aBuyerCantShowOrdersFromOtherCustomers()
    {

        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $order = factory(Order::class)->create();

        $this->assertNotEquals($buyerUser->id, $order->user_id);
        $this->get(route('order.show', compact('order')))
            ->assertStatus(403);

    }
}
