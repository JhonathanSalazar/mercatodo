<?php

namespace Tests\Feature\Api\Products;

use App\Entities\Product;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestUserCantUpdateProducts()
    {
        $product = factory(Product::class)->create();

        $this->jsonApi()->patch(route('api.v1.products.update', $product))
        ->assertStatus(401);
    }

    /**
     * @test
     */
    public function authenticatedUserCanUpdateProducts()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        Sanctum::actingAs($user);

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'id' => (string)$product->getRouteKey(),
                'attributes' => [
                    'name' => 'Name changed',
                    'branch' => 'Branch changed',
                    'ean' => $product->ean . '1'
                ]
            ]
        ])->patch(route('api.v1.products.update', $product))
            ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => 'Name changed',
            'branch' => 'Branch changed',
            'ean' => $product->ean . '1'
        ]);
    }

    /**
     * @test
     */
    public function authenticatedUserCanUpdateProductTitleOnly()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();

        Sanctum::actingAs($user);

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'id' => (string)$product->getRouteKey(),
                'attributes' => [
                    'name' => 'Name changed',
                ]
            ]
        ])->patch(route('api.v1.products.update', $product))
            ->assertStatus(200);

        $this->assertDatabaseHas('products', [
            'name' => 'Name changed',
        ]);
    }

}
