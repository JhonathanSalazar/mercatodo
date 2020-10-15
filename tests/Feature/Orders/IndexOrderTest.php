<?php

namespace Tests\Feature\Orders;

use App\User;
use App\Order;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;


class IndexOrderTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function aBuyerCanIndexYourOrders()
    {
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $orders = factory(Order::class, 5)->create([
            'user_id' => $buyerUser
        ]);

        $response = $this->get(route('orders.index', $buyerUser));

        $response->assertStatus(200);

        $orders->each(function ($order) use ($response) {
            $response->assertSee($order->id);
            $response->assertSee($order->item_count);
            $response->assertSee($order->grand_total);
            $response->assertSee($order->status);
        });

    }

    /**
     * @test
     */
    public function aAdminCantIndexOrders()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        factory(Order::class, 5)->create([
            'user_id' => $admUser
        ]);

        $this->get(route('orders.index', $admUser))->assertStatus(403);
    }
}
