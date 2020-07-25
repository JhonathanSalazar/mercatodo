<?php

namespace Tests\Feature;

use App\Product;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProductsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @test
     */
    public function guestCanNotManageProducts()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $product = factory(Product::class)->create();
        Auth::logout();

        $this->get(route('admin.products.index'))->assertRedirect(route('login'));
        $this->get(route('admin.products.create'))->assertRedirect(route('login'));
        $this->get($product->path())->assertRedirect(route('login'));
        $this->post(route('admin.products.store'), $product->toArray())->assertRedirect(route('login'));

    }

    /**
     * @test
    */
    public function adminCanCreateProducts()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $this->get(route('admin.products.index'))->assertStatus(200);

        $attributes = [
            'name' => $this->faker->firstName,
            'user_id' => auth()->id()
            ];

        $response = $this->post(route('admin.products.store'), $attributes);
        $product = Product::where($attributes)->first();

        $this->assertDatabaseHas('products', $attributes);
        $response->assertRedirect(route('admin.products.edit', $product));
    }

    /**
     * @test
     */
    public function productRequireANameToCreate()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attribute = factory(Product::class)->raw(['name' => '']);

        $this->post(route('admin.products.store'), $attribute)->assertSessionHasErrors('name');
    }

    /**
     * @test
     */
    public function productRequiredBranchToUpdate()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $product = factory(Product::class)->create();
        $this->get(route('admin.products.edit', $product))->assertSee($product->branch);

        $product->branch = '';
        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('branch');

    }

    /**
     * @test
     */
    public function productRequiredPriceToUpdate()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $product = factory(Product::class)->create();
        $this->get(route('admin.products.edit', $product))->assertSee($product->price);

        $product->price = '';
        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('price');

    }

    /**
     * @test
     */
    public function productRequiredEANToUpdate()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $product = factory(Product::class)->create();
        $this->get(route('admin.products.edit', $product))->assertSee($product->price);

        $product->ean = '';
        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('ean');

    }

    /**
     * @test
     */
    public function adminCanViewAnSpecificProduct()
    {
        //$this->withoutExceptionHandling();

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
