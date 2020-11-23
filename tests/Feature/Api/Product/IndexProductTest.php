<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_fetch_single_product()
    {
        $product = factory(Product::class)->create();

        $response = $this->getJson(route('api.v1.products.show', $product));

        $response->assertExactJson([
            'data' => [
                'type' => 'products',
                'id' => (string)$product->getRouteKey(),
                'attributes' => [
                    'name' => $product->name,
                    'ean' => (string)$product->ean,
                    'branch' => $product->branch,
                    'price' => (string)$product->price,
                    'description' => $product->description
                ],
                'links' => [
                    'self' => route('api.v1.products.show', $product)
                ],
            ]
        ]);
    }


    /**
     * @test
     */
    public function can_fetch_all_products()
    {
        $product = factory(Product::class, 3)->create();

        $response = $this->getJson(route('api.v1.products.index'));

        $response->assertJsonFragment([
            'data' => [
                [
                    'type' => 'products',
                    'id' => (string)$product[0]->getRouteKey(),
                    'attributes' => [
                        'name' => $product[0]->name,
                        'ean' => (string)$product[0]->ean,
                        'branch' => $product[0]->branch,
                        'price' => (string)$product[0]->price,
                        'description' => $product[0]->description
                    ],
                    'links' => [
                        'self' => route('api.v1.products.show', $product[0])
                    ]
                ],
                [
                    'type' => 'products',
                    'id' => (string)$product[1]->getRouteKey(),
                    'attributes' => [
                        'name' => $product[1]->name,
                        'ean' => (string)$product[1]->ean,
                        'branch' => $product[1]->branch,
                        'price' => (string)$product[1]->price,
                        'description' => $product[1]->description
                    ],
                    'links' => [
                        'self' => route('api.v1.products.show', $product[1])
                    ]
                ],
                [
                    'type' => 'products',
                    'id' => (string)$product[2]->getRouteKey(),
                    'attributes' => [
                        'name' => $product[2]->name,
                        'ean' => (string)$product[2]->ean,
                        'branch' => $product[2]->branch,
                        'price' => (string)$product[2]->price,
                        'description' => $product[2]->description
                    ],
                    'links' => [
                        'self' => route('api.v1.products.show', $product[2])
                    ]
                ]
            ],
        ]);
    }
}
