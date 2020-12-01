<?php

namespace Tests\Feature\Admin\Product;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\Category;
use App\Entities\Product;
use App\Entities\User;
use Spatie\Permission\Models\Permission;
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
    public function guestCantUpdateProducts()
    {
        $product = factory(Product::class)->create();

        $product->name = $this->faker->firstName;
        $product->description = $this->faker->sentence;
        $product->ean = $this->faker->randomNumber(8);
        $product->branch = $this->faker->lastName;

        $this->get(route('admin.products.show', $product))
        ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantUpdateProducts()
    {
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $product = factory(Product::class)->create();

        $product->name = $this->faker->firstName;
        $product->description = $this->faker->sentence;
        $product->ean = $this->faker->randomNumber(8);
        $product->branch = $this->faker->lastName;

        $this->get(route('admin.products.show', $product))
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminWithPermissionCanUpdateProducts()
    {
        $updateProductPermission =  Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($updateProductPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $name = $this->faker->firstName;
        $description = $this->faker->sentence;
        $ean = $this->faker->randomNumber(8);
        $branch = $this->faker->lastName;
        $price = $this->faker->numberBetween(1000,100000);

        $this->put(route('admin.products.update', [
            'product' => $product,
            'name' => $name,
            'description' => $description,
            'ean' => $ean,
            'branch' => $branch,
            'price' => $price,
            'category' => $category->id
        ]));

        $this->assertDatabaseHas('products', [
            'name' => $name,
            'description' => $description,
            'ean' => $ean,
            'branch' => $branch,
            'price' => $price
        ]);
    }

    /**
     * @test
     */
    public function adminWithoutPermissionCantUpdateProducts()
    {
        Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $name = $this->faker->firstName;
        $description = $this->faker->sentence;
        $ean = $this->faker->randomNumber(8);
        $branch = $this->faker->lastName;
        $price = $this->faker->numberBetween(1000,100000);

        $this->put(route('admin.products.update', [
            'product' => $product,
            'name' => $name,
            'description' => $description,
            'ean' => $ean,
            'branch' => $branch,
            'price' => $price,
            'category' => $category->id
        ]))
        ->assertStatus(403);

        $product->fresh();

        $this->assertNotEquals($name, $product->name);
        $this->assertNotEquals($description, $product->description);
        $this->assertNotEquals($ean, $product->ean);
        $this->assertNotEquals($branch, $product->branch);
    }

    /**
     * @test
     */
    public function superCanUpdateProducts()
    {
        Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);

        $superRole = Role::create(['name' => PlatformRoles::SUPER]);
        $superUser = factory(User::class)->create()->assignRole($superRole);
        $this->actingAs($superUser);

        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $name = $this->faker->firstName;
        $description = $this->faker->sentence;
        $ean = $this->faker->randomNumber(8);
        $branch = $this->faker->lastName;
        $price = $this->faker->numberBetween(1,10) * 1000;

        $this->put(route('admin.products.update', [
            'product' => $product,
            'name' => $name,
            'description' => $description,
            'ean' => $ean,
            'branch' => $branch,
            'price' => $price,
            'category' => $category->id
        ]));

        $updatedProduct = Product::first();

        dump($name, $updatedProduct->name);

        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'name' => $name,
            'description' => $description,
            'ean' => $ean,
            'branch' => $branch,
            'price' => $price
        ]);
    }


    /**
     * @test
     */
    public function productRequireNameToUpdate()
    {
        $updateProductPermission =  Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($updateProductPermission);
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
        $updateProductPermission =  Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($updateProductPermission);
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
        $updateProductPermission =  Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($updateProductPermission);
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
        $updateProductPermission =  Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($updateProductPermission);
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
        $updateProductPermission =  Permission::create(['name' => Permissions::UPDATE_PRODUCTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($updateProductPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $product = factory(Product::class)->create();
        $this->actingAs($admUser);

        $product->price = '';

        $this->put(route('admin.products.update', $product), compact('product'))
            ->assertSessionHasErrors('price');

    }

}
