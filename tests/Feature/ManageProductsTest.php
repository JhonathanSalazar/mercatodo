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
        $this->withoutExceptionHandling();

        //1. Given (Obteniendo, creando el contexto)
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $this->get(route('admin.products.create'))->assertStatus(200);

        $attributes = factory(Product::class)->raw();


        //2. When (Cuando)
        $response = $this->post(route('admin.products.store'), $attributes);

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

        $this->post(route('admin.products.store'), $attribute)->assertSessionHasErrors('name');
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

        $this->post(route('admin.products.store'), $attribute)->assertSessionHasErrors('branch');
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

        $this->post(route('admin.products.store'), $attribute)->assertSessionHasErrors('price');
    }

    /**
     * @test
     */
    public function productRequiredAEAN()
    {
        //$this->withoutExceptionHandling();

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $attribute = factory(Product::class)->raw(['ean' => '']);

        $this->post(route('admin.products.store'), $attribute)->assertSessionHasErrors('ean');
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
