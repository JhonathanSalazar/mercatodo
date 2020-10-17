<?php

namespace Tests\Feature\Admin\Product;

use App\Models\User;
use App\Models\Product;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteProductsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function adminCanDeleteProducts()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $this->delete(route('admin.products.destroy', $product))
            ->assertRedirect(route('admin.products.index'));

        $this->assertDeleted('products', array($product));
    }
}
