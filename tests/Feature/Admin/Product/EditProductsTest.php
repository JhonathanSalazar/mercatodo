<?php

namespace Tests\Feature\Admin\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class EditProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantEditProducts()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();

        $this->get(route('admin.products.edit', $product))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantEditProducts()
    {
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);
        $product = factory(Product::class)->create();

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
