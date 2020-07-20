<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateProductTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function adminCanCreateProducts()
    {
        $this->withoutExceptionHandling();

        //1. Given (Obteniendo, creando el contexto)
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attributes = [
            'name' => $this->faker->name,
            'branch' => $this->faker->name,
            'price' => $this->faker->randomNumber(5)
        ];


        //2. When (Cuando)
        $response = $this->post(route('admin.products.create'), $attributes);

        //3. Then (Comprobamos)
        $this->assertDatabaseHas('products', $attributes);
        $response->assertRedirect(route('admin.products.index'));
        $this->get(route('admin.products.index'))
            ->assertSee($attributes['name']);
    }

    /**
     * @test
     */
    public function productRequiredAName()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attribute = factory(Product::class)->raw(['name' => '']);

        $this->post(route('admin.products.create'), $attribute)->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function productRequiredABranch()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attribute = factory(Product::class)->raw(['branch' => '']);

        $this->post(route('admin.products.create'), $attribute)->assertSessionHasErrors('branch');
    }

    /**
     * @test
     */
    public function productRequiredAPrice()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attribute = factory(Product::class)->raw(['price' => '']);

        $this->post(route('admin.products.create'), $attribute)->assertSessionHasErrors('price');
    }

    /**
     * @test
     */
    public function adminCanViewAProduct()
    {
        $this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $product = factory(Product::class)->create();

        $this->get($product->path())
            ->assertSee($product->name)
            ->assertSee($product->branch)
            ->assertSee($product->price);
    }

}
