<?php

namespace Tests\Feature\Pages;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductDetailsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aUserCanViewDetailedProduct()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        factory(User::class)->create()->assignRole($adminRole);

        $product = factory(Product::class)->create();

        $response = $this->get(route('products.details', compact('product')));

        $response->assertSee($product->name)
            ->assertSee($product->branch)
            ->assertSee($product->price)
            ->assertSee($product->description);
    }
}
