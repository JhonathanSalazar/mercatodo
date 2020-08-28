<?php

namespace Tests\Unit;

use App\User;
use App\Product;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itHasAPath()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $product = factory(Product::class)->create();

        $this->assertEquals('/admin/products/' . $product->id, $product->showUrl());
    }
}
