<?php

namespace Tests\Feature\Api\Products;

use App\Entities\Category;
use App\Entities\Product;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IncludeCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canIncludeCategoriesRelationShip()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $product->category_id = $category->id;
        $product->save();

        Sanctum::actingAs($user);

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
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();
        $product->category_id = $category->id;
        $product->save();

        Sanctum::actingAs($user);

        $this->jsonApi()
            ->get(route('api.v1.products.relationships.categories', $product))
            ->assertSee($product->category->name);

        $this->jsonApi()
            ->get(route('api.v1.products.relationships.categories.read', $product))
            ->assertSee($product->category->getRouteKey());
    }
}
