<?php

namespace Tests\Feature\Orders;

use Tests\TestCase;
use App\Entities\User;
use App\Entities\Order;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $this->delete(route('orders.delete', $order))
            ->assertRedirect(route('orders.index', $buyerUser));

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

        $this->delete(route('orders.delete', $order))->assertStatus(403);
    }
}
