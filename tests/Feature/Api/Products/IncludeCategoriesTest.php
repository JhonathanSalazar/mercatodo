<?php

namespace Tests\Feature\Api\Products;

use App\Entities\Category;
use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IncludeCategoriesTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function canIncludeCategoriesRelationShip()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $product->category_id = $category->id;

        $this->jsonApi()
            ->includePaths('categories')
            ->get(route('api.v1.products.read', $product))
            ->assertSee($product->category->name)
            ->assertJsonFragment([
                'related' => route('api.v1.products.relationships.categories', $product)
            ])
            ->assertJsonFragment([
                'self' => route('api.v1.products.relationships.categories.read', $product)
            ]);
    }

    /**
     * @test
     */
    public function canFetchRelatedCategories()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $product->category_id = $category->id;

        $this->jsonApi()
            ->get(route('api.v1.products.relationships.categories', $product))
            ->assertSee($product->category->name);

        $this->jsonApi()
            ->get(route('api.v1.products.relationships.categories.read', $product))
            ->assertSee($product->category->getRouteKey());
    }
}
