<?php

namespace Tests\Feature\Admin\Product;

use App\Product;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;

class IndexProductsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantIndexProducts()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();

        $response = $this->get(route('admin.products.index', compact('product')));

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantIndexProducts()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $buyerUser = factory(User::class)->create();
        $products = factory(Product::class)->create();
        $this->actingAs($buyerUser);

        $response = $this->get(route('admin.products.index', compact('products')));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanIndexProducts()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $products = factory(Product::class,3)->create();
        $this->actingAs($admUser);

        $response = $this->get(route('admin.products.index', compact('products')));

        $response->assertStatus(200)
            ->assertSee($products[0]->name)
            ->assertSee($products[0]->ean)
            ->assertSee($products[0]->price)
            ->assertSee($products[1]->name)
            ->assertSee($products[1]->ean)
            ->assertSee($products[1]->price)
            ->assertSee($products[2]->name)
            ->assertSee($products[2]->ean)
            ->assertSee($products[2]->price);
    }
}
