<?php

namespace Tests\Feature\Admin\Product;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateProductsTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    /**
     * @test
     */
    public function adminCanUpdateProducts()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $product->name = $this->faker->firstName;
        $product->description = $this->faker->sentence;
        $product->ean = $this->faker->randomNumber(8);
        $product->branch = $this->faker->lastName;
        $this->put(route('admin.products.update', $product));

        $this->assertDatabaseHas('products', compact($product));
    }

    /**
     * @test
     */
    public function productRequireNameToUpdate()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $product->name = '';

        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('name');

    }

    /**
     * @test
     */
    public function productRequireEANToUpdate()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $product->ean = '';

        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('ean');

    }

    /**
     * @test
     */
    public function productRequireBranchToUpdate()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $product->branch = '';

        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('branch');

    }

    /**
     * @test
     */
    public function productRequireDescriptionToUpdate()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $product->description = '';

        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('description');

    }

    /**
     * @test
     */
    public function productRequirePriceToUpdate()
    {

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $product->price = '';

        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('price');

    }
}
