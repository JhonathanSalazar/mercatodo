<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Product;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestsUserCanCreateProducts()
    {
        $product = array_filter(factory(Product::class)->raw(['user_id' => null]));
        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(401)
            ->dump();

        $this->assertDatabaseMissing('products', $product);
    }

    /**
     * @test
     */
    public function authenticatedUserCanCreateProducts()
    {
        $user = factory(User::class)->create();
        $product = array_filter(factory(Product::class)->raw(['user_id' => '']));
        $this->assertDatabaseMissing('products', $product);
        Sanctum::actingAs($user);

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product
            ]
        ])->post(route('api.v1.products.create'))
            ->assertCreated();

        $this->assertDatabaseHas('products', $product);
    }

    /**
     * @test
     */
    public function nameIsRequiredToCreateProducts()
    {
        $product = factory(Product::class)->raw(['name' => '']);
        Sanctum::actingAs(factory(User::class)->create());

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/name');

        $this->assertDatabaseMissing('products', $product);
    }

    /**
     * @test
     */
    public function descriptionIsRequiredToCreateProducts()
    {
        $product = factory(Product::class)->raw(['description' => '']);
        Sanctum::actingAs(factory(User::class)->create());


        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/description');

        $this->assertDatabaseMissing('products', $product);
    }

    /**
     * @test
     */
    public function branchIsRequiredToCreateProducts()
    {
        $product = factory(Product::class)->raw(['branch' => '']);
        Sanctum::actingAs(factory(User::class)->create());


        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/branch');

        $this->assertDatabaseMissing('products', $product);
    }

    /**
     * @test
     */
    public function priceIsRequiredToCreateProducts()
    {
        $product = factory(Product::class)->raw(['price' => '']);
        Sanctum::actingAs(factory(User::class)->create());


        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/price');

        $this->assertDatabaseMissing('products', $product);
    }

    /**
     * @test
     */
    public function eanIsRequiredToCreateProducts()
    {
        $product = factory(Product::class)->raw(['ean' => '']);
        Sanctum::actingAs(factory(User::class)->create());


        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/ean');

        $this->assertDatabaseMissing('products', $product);
    }

    /**
     * @test
     */
    public function eanMustBeUniqueToCreateProducts()
    {
        factory(Product::class)->create(['ean' => '123123']);
        Sanctum::actingAs(factory(User::class)->create());

        $product = factory(Product::class)->raw(['ean' => '123123']);

        $this->jsonApi()->content([
            'data' => [
                'type' => 'products',
                'attributes' => $product
            ]
        ])->post(route('api.v1.products.create'))
            ->assertStatus(422)
            ->assertSee('data\/attributes\/ean');

        $this->assertDatabaseMissing('products', $product);
    }
}
