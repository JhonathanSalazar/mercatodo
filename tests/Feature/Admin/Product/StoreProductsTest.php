<?php

namespace Tests\Feature\Admin\Product;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\User;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
    public function adminWithoutPermissionCantCreateProducts()
    {
        Permission::create(['name' => Permissions::CREATE_PRODUCTS]);

        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attributes = [
            'name' => $this->faker->firstName,
            'user_id' => auth()->id()
        ];

        $response = $this->post(route('admin.products.store'), $attributes);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('products', $attributes);
    }

    /**
     * @test
     */
    public function adminWithPermissionCanCreateProducts()
    {
        $createProductPermission = Permission::create(['name' => Permissions::CREATE_PRODUCTS]);

        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($createProductPermission);
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
        $createProductPermission = Permission::create(['name' => Permissions::CREATE_PRODUCTS]);

        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($createProductPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attribute = factory(Product::class)->raw(['name' => '']);

        $this->post(route('admin.products.store'), $attribute)->assertSessionHasErrors('name');
    }
}
