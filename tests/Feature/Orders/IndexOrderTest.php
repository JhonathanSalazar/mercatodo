<?php

namespace Tests\Feature\Orders;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexOrderTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function aBuyerCanIndexYourOrders()
    {
        $this->withoutExceptionHandling();

        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $orders = factory(Order::class, 5)->create([
            'user_id' => $buyerUser
        ]);

        $response = $this->get(route('order.index', $buyerUser));

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

        $this->get(route('order.index', $admUser))
        ->assertStatus(403);
    }
}
