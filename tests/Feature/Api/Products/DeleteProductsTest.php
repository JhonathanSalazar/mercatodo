<?php

namespace Tests\Feature\Api\Products;

use App\Entities\Product;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteProductsTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function guestUserCantDeleteProducts()
    {
        $product = factory(Product::class)->create();

        $this->jsonApi()->delete(route('api.v1.products.delete', $product))
            ->assertStatus(401);
    }

    /**
     * @test
     */
    public function authenticatedUserCanDeleteProducts()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        Sanctum::actingAs($user);

        $this->jsonApi()->delete(route('api.v1.products.delete', $product))
            ->assertStatus(204);
    }
}
