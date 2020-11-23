<?php

namespace Tests\Feature\Api\Products;

use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function canFetchSingleProduct()
    {
        $product = factory(Product::class)->create();

        $response = $this->jsonApi()->get(route('api.v1.products.read', $product));

        $response->assertExactJson([
            'data' => [
                'type' => 'products',
                'id' => (string)$product->getRouteKey(),
                'attributes' => [
                    'name' => $product->name,
                    'ean' => (string)$product->ean,
                    'branch' => $product->branch,
                    'price' => (string)$product->price,
                    'description' => $product->description,
                    'created-at' => $product->created_at->toAtomString(),
                    'updated-at' => $product->updated_at->toAtomString()
                ],
                'links' => [
                    'self' => route('api.v1.products.read', $product)
                ],
            ]
        ]);
    }


    /**
     * @test
     */
    public function canFetchAllProducts()
    {
        $product = factory(Product::class, 3)->create();

        $response = $this->jsonApi()->get(route('api.v1.products.index'));

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
                        'description' => $product[0]->description,
                        'created-at' => $product[0]->created_at->toAtomString(),
                        'updated-at' => $product[0]->updated_at->toAtomString()
                    ],
                    'links' => [
                        'self' => route('api.v1.products.read', $product[0])
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
                        'description' => $product[1]->description,
                        'created-at' => $product[1]->created_at->toAtomString(),
                        'updated-at' => $product[1]->updated_at->toAtomString()
                    ],
                    'links' => [
                        'self' => route('api.v1.products.read', $product[1])
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
                        'description' => $product[2]->description,
                        'created-at' => $product[2]->created_at->toAtomString(),
                        'updated-at' => $product[2]->updated_at->toAtomString()
                    ],
                    'links' => [
                        'self' => route('api.v1.products.read', $product[2])
                    ]
                ]
            ],
        ]);
    }
}
