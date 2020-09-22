<?php

namespace Tests\Feature\Cart;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AddProductCartTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function aBuyerCanAddCartProduct()
    {

        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $product = factory(Product::class)->create();

        $_REQUEST['quantity'] = 1;

        $userId = auth()->id();

        $response = $this->get(route('cart.add', compact('product')))->assertStatus(302);

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
    public function aGuestCantAddCartProduct()
    {
        $product = factory(Product::class)->create();
    }
}
