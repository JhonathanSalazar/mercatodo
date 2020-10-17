<?php

namespace Tests\Feature\Cart;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddCartProductTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantAddCartProduct()
    {
        $product = factory(Product::class)->create();

        $this->post(route('cart.add', [
            'product' => $product,
            'quantity' => 1
        ]))->assertRedirect(route('login'));

    }

    /**
     * @test
     */
    public function buyerCanAddCartProduct()
    {
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $product = factory(Product::class)->create();

        $userId = auth()->id();

        $this->post(route('cart.add', [
            'product' => $product,
            'quantity' => 1
        ]))->assertStatus(302);

        $cartProducts = \Cart::session($userId)->getContent();

        foreach($cartProducts as $cartProduct) {
            $this->assertEquals($product->id, $cartProduct->id);
            $this->assertEquals($product->name, $cartProduct->name);
            $this->assertEquals($product->price, $cartProduct->price);
        }

    }

    /**
     * @test
     */
    public function adminCantAddCartProduct()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $adminUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($adminUser);

        $product = factory(Product::class)->create();

        $userId = auth()->id();

        $this->post(route('cart.add', [
            'product' => $product,
            'quantity' => 1
        ]))->assertStatus(403);

        $cartProducts = \Cart::session($userId)->getContent();

        $this->assertEmpty($cartProducts);
    }
}
