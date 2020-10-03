<?php

namespace Tests\Feature\Admin\Product;

use App\Product;
use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantShowProducts()
    {

        $product = factory(Product::class)->create();

         $response = $this->get(route('admin.products.show', $product));

         $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantShowProducts()
    {
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $product = factory(Product::class)->create();

        $response = $this->get(route('admin.products.edit', $product));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanShowAnProduct()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $product = factory(Product::class)->create();

        $response = $this->get(route('admin.products.show', compact('product')));

        $response->assertStatus(200)
            ->assertSee($product->name)
            ->assertSee($product->ean)
            ->assertSee($product->branch)
            ->assertSee($product->price)
            ->assertSee($product->description);
    }
}
