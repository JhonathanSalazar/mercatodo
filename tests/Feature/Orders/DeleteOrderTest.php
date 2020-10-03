<?php

namespace Tests\Feature\Orders;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class DeleteOrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aBuyerCanDeleteYourOrders()
    {
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $order = factory(Order::class)->create([
            'user_id' => $buyerUser
        ]);

        $this->delete(route('order.delete', $order))
            ->assertRedirect(route('order.index', $buyerUser));

        $this->assertDeleted('orders', array($order));
    }

    /**
     * @test
     */
    public function aBuyerCantDeleteOrdersFromOtherCustomers()
    {
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $order = factory(Order::class)->create();

        $this->delete(route('order.delete', $order))->assertStatus(403);
    }
}
