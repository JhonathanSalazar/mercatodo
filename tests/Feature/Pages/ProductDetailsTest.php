<?php

namespace Tests\Feature\Pages;

use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDetailsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aUserCanViewDetailedProduct()
    {
        $product = factory(Product::class)->create();

        $response = $this->get(route('products.details', compact('product')));

        $response->assertSee($product->name)
            ->assertSee($product->branch)
            ->assertSee($product->price)
            ->assertSee($product->description);
    }
}
