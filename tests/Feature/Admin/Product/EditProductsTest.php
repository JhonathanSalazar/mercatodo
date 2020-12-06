<?php

namespace Tests\Feature\Admin\Product;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\User;
use App\Entities\Product;
use Spatie\Permission\Models\Permission;
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
    public function adminWithPermissionCanEditProducts()
    {
        $editProductPermission = Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($editProductPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $this->get(route('admin.products.edit', $product))
            ->assertStatus(200)
            ->assertSee($product->name);
    }

    /**
     * @test
     */
    public function adminWithoutPermissionCantEditProducts()
    {
        Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $this->get(route('admin.products.edit', $product))
            ->assertStatus(403);
    }
}
