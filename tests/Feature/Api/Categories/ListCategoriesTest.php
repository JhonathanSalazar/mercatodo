<?php

namespace Tests\Feature\Api\Categories;

use App\Entities\Category;
use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListCategoriesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canFetchSingleCategory()
    {
        $category = factory(Category::class)->create();

        $response = $this->jsonApi()->get(route('api.v1.categories.read', $category));

        $response->assertJson([
            'data' => [
                'type' => 'categories',
                'id' => (string)$category->getRouteKey(),
                'attributes' => [
                    'name' => $category->name,
                    'url' => $category->url,
                ],
                'links' => [
                    'self' => route('api.v1.categories.read', $category)
                ],
            ]
        ]);
    }

    /**
     * @test
     */
    public function canFetchAllCategories()
    {
        $categories = factory(Category::class, 3)->create();

        $response = $this->jsonApi()->get(route('api.v1.categories.index'));

        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'categories',
                    'id' => (string)$categories[0]->getRouteKey(),
                    'attributes' => [
                        'name' => $categories[0]->name,
                        'url' => (string)$categories[0]->url,
                    ],
                    'links' => [
                        'self' => route('api.v1.categories.read', $categories[0])
                    ]
                ],
                [
                    'type' => 'categories',
                    'id' => (string)$categories[1]->getRouteKey(),
                    'attributes' => [
                        'name' => $categories[1]->name,
                        'url' => (string)$categories[1]->url,
                    ],
                    'links' => [
                        'self' => route('api.v1.categories.read', $categories[1])
                    ]
                ],
                [
                    'type' => 'categories',
                    'id' => (string)$categories[2]->getRouteKey(),
                    'attributes' => [
                        'name' => $categories[2]->name,
                        'url' => (string)$categories[2]->url,
                    ],
                    'links' => [
                        'self' => route('api.v1.categories.read', $categories[2])
                    ]
                ]
            ],
        ]);
    }
}
