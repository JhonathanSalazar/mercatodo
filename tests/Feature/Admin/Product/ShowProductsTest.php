<?php

namespace Tests\Feature\Admin\Product;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\Product;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
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
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $product = factory(Product::class)->create();

        $response = $this->get(route('admin.products.edit', $product));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminWithPermissionCanShowAnProduct()
    {
        $viewProductPermission = Permission::create(['name' => Permissions::VIEW_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($viewProductPermission);
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

    /**
     * @test
     */
    public function adminWithoutPermissionCanShowAnProduct()
    {
        Permission::create(['name' => Permissions::VIEW_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $product = factory(Product::class)->create();

        $response = $this->get(route('admin.products.show', compact('product')));

        $response->assertStatus(403);
    }
}
