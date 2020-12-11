<?php

namespace Tests\Feature\Cart;

use App\Entities\Product;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexCartProductTest extends TestCase
{
    use RefreshDatabase;


    /**
     * @test
     */
    public function guestCantIndexCartProduct()
    {
        $this->get(route('cart.index'))->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCanIndexCartProduct()
    {
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $product = factory(Product::class)->create();

        //For each en caso de usar 10 products en el trait.
        //$this->addCart($product, $buyerUser);

        $this->post(route('cart.add', [
            'product' => $product,
            'quantity' => 1
        ]))->assertStatus(302);

        $response = $this->get(route('cart.index'));

        $response->assertSee($product->name);
        $response->assertSee($product->price);
    }


    /**
     * @test
     */
    public function adminCantIndexCartProduct()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $adminUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($adminUser);

        $this->get(route('cart.index'))->assertStatus(403);
    }
}
