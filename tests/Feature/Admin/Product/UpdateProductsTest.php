<?php

namespace Tests\Feature\Admin\Product;

use App\Product;
use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

        $name = $this->faker->firstName;
        $description = $this->faker->sentence;
        $ean = $this->faker->randomNumber(8);
        $branch = $this->faker->lastName;

        $product->name = $name;
        $product->description = $description;
        $product->ean = $ean;
        $product->branch = $branch;

        $this->put(route('admin.products.update', $product));

        $product->fresh();

        $this->assertEquals($name, $product->name);
        $this->assertEquals($description, $product->description);
        $this->assertEquals($ean, $product->ean);
        $this->assertEquals($branch, $product->branch);
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
