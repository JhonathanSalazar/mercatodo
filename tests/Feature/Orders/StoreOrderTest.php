<?php

namespace Tests\Feature\Orders;

use App\Order;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StoreOrderTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantCreateOrders()
    {

        //Create Cart status pending

        $this->get(route('cart.checkout'))->assertRedirect(route('login'));

    }


    /**
     * @test
     */
    public function buyerCanCreateOrders()
    {

    }

    /**
     * @test
     */
    public function aProductInCartMinIsRequiredToCreateAnOrder()
    {

    }

    /**
     * @test
     */
    public function adminCantCreateOrders()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $adminUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($adminUser);

        //Create Cart status pending

        $this->get(route('cart.checkout'))->assertStatus(403);

    }
}
