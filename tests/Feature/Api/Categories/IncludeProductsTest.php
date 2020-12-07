<?php

namespace Tests\Feature\Api\Categories;

use App\Entities\Category;
use App\Entities\Product;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IncludeProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canIncludeProductsRelation()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        factory(Product::class)->create(['category_id' => $category]);

        Sanctum::actingAs($user);

        $this->jsonApi()
            ->includePaths('products')
            ->get(route('api.v1.categories.read', $category))
            ->assertSee($category->products[0]->name)
            ->assertJsonFragment([
                'related' => route('api.v1.categories.relationships.products', $category)
            ])
            ->assertJsonFragment([
                'self' => route('api.v1.categories.relationships.products.read', $category)
            ]);
    }

    /**
     * @test
     */
    public function canFetchRelatedProducts()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        factory(Product::class)->create(['category_id' => $category]);

        Sanctum::actingAs($user);

        $this->jsonApi()
            ->get(route('api.v1.categories.relationships.products', $category))
            ->assertSee($category->products[0]->name);

        $this->jsonApi()
            ->get(route('api.v1.categories.relationships.products.read', $category))
            ->assertSee($category->products[0]->getRouteKey());
    }
}
