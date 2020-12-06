<?php

namespace Tests\Feature\Api\Products;

use App\Entities\Category;
use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FilterProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canFilterProductsByCategory()
    {
        $category = factory(Category::class)->create();
        factory(Product::class)->create(['category_id' => $category]);
        factory(Product::class)->create();

        $this->jsonApi()
            ->filter(['categories' => $category->getRouteKey()])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(1, 'data');
    }

    /**
     * @test
     */
    public function canFilterProductsBySeveralCategory()
    {
        $category1 = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();
        factory(Product::class)->create(['category_id' => $category1]);
        factory(Product::class)->create(['category_id' => $category2]);

        $this->jsonApi()
            ->filter([
                'categories' => $category1->getRouteKey() . ',' . $category2->getRouteKey()
            ])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(2, 'data');
    }
}
