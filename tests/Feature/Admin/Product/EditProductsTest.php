<?php

namespace Tests\Feature\Admin\Product;

use App\Models\User;
use App\Models\Product;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;


class EditProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantEditProducts()
    {
        $product = factory(Product::class)->create();

        $this->get(route('admin.products.edit', $product))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantEditProducts()
    {
        $product = factory(Product::class)->create();
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $this->get(route('admin.products.edit', $product))
            ->assertStatus(403);
    }


    /**
     * @test
     */
    public function adminCanEditProducts()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $this->get(route('admin.products.edit', $product))
            ->assertStatus(200)
            ->assertSee($product->name);
    }
}
