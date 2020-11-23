<?php

namespace Tests\Feature\Api\Product;

use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateProductsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function CanCreateProducts()
    {
        $product = factory(Product::class)->raw();
        $this->assertDatabaseMissing('products', $product);

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
