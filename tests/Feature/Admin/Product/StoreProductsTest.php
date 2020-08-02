<?php

namespace Tests\Feature\Admin\Product;

use App\User;
use App\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class StoreProductsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guestCantCreateProducts()
    {

        $product = factory(Product::class)->raw();

        $this->get(route('admin.products.create', $product))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantCreateProducts()
    {
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $attributes = [
            'name' => $this->faker->firstName,
            'user_id' => auth()->id()
        ];

        $response = $this->post(route('admin.products.store'), $attributes);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminCanCreateProducts()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attributes = [
            'name' => $this->faker->firstName,
            'user_id' => auth()->id()
        ];

        $response = $this->post(route('admin.products.store'), $attributes);
        $product = Product::where($attributes)->first();

        $this->assertDatabaseHas('products', $attributes);
        $response->assertRedirect(route('admin.products.edit', $product));
    }

    /**
     * @test
     */
    public function productRequireANameToCreate()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attribute = factory(Product::class)->raw(['name' => '']);

        $this->post(route('admin.products.store'), $attribute)->assertSessionHasErrors('name');
    }

}
