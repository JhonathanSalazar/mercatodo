<?php

namespace Tests\Feature\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IndexProductsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantIndexProducts()
    {
        $product = factory(Product::class)->create();

        $response = $this->get(route('admin.products.index', compact('product')));

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantIndexProducts()
    {
        $products = factory(Product::class)->create();
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $response = $this->get(route('admin.products.index', compact('products')));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanIndexProducts()
    {
        $products = factory(Product::class,30)->create();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $response = $this->get(route('admin.products.index', compact('products')));

        $responseProducts = $response->getOriginalContent()['products'];

        $response->assertStatus(200);

        $responseProducts->each(function($item) use ($response) {
            $response->assertSee($item->name);
            $response->assertSee($item->ean);
            $response->assertSee($item->price);
        });
    }
}
