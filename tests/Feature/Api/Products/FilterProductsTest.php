<?php

namespace Tests\Feature\Api\Products;

use App\Entities\Category;
use App\Entities\Product;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FilterProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canFilterProductsByCategory()
    {
        $user = factory(User::class)->create();
        $category = factory(Category::class)->create();
        factory(Product::class)->create(['category_id' => $category]);
        factory(Product::class)->create();

        Sanctum::actingAs($user);

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
        $user = factory(User::class)->create();
        $category1 = factory(Category::class)->create();
        $category2 = factory(Category::class)->create();
        factory(Product::class)->create(['category_id' => $category1]);
        factory(Product::class)->create(['category_id' => $category2]);

        Sanctum::actingAs($user);

        $this->jsonApi()
            ->filter([
                'categories' => $category1->getRouteKey() . ',' . $category2->getRouteKey()
            ])
            ->get(route('api.v1.products.index'))
            ->assertJsonCount(2, 'data');
    }
}
