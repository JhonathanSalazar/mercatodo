<?php

namespace Tests\Feature\Admin\User;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UpdateUsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function guestCantUpdateUsers()
    {
        $user = factory(User::class)->create();

        $this->patch(route('admin.users.update', [
            'user' => $user->id,
            'name' => $this->faker->firstName,
            'enable' => true,
            'email' => $this->faker->email
        ]))
            ->assertRedirect('login');

        $userDatabase = User::first();

        $this->assertEquals($user->name, $userDatabase->name);
        $this->assertEquals($user->email, $userDatabase->email);
    }

    /**
     * @test
     */
    public function buyerCantUpdateUsers()
    {
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $user = factory(User::class)->create();

        $this->patch(route('admin.users.update', [
            'user' => $user->id,
            'name' => $this->faker->firstName,
            'enable' => true,
            'email' => $this->faker->email
        ]))
            ->assertStatus(403);

        $userDatabase = User::where('id', '=', $user->id)->first();

        $this->assertEquals($user->name, $userDatabase->name);
        $this->assertEquals($user->email, $userDatabase->email);
    }

    /**
     * @test
     */
    public function adminWithoutPermissionCantUpdateUsers()
    {
        Permission::create(['name' => Permissions::UPDATE_USERS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $adminUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($adminUser);

        $user = factory(User::class)->create();

        $this->patch(route('admin.users.update', [
            'user' => $user->id,
            'name' => $this->faker->firstName,
            'enable' => true,
            'email' => $this->faker->email
        ]))
            ->assertStatus(403);

        $userDatabase = User::where('id', '=', $user->id)->first();

        $this->assertEquals($user->name, $userDatabase->name);
        $this->assertEquals($user->email, $userDatabase->email);
    }

    /**
     * @test
     */
    public function adminWithPermissionCanUpdateUsers()
    {
        $updatePermission = Permission::create(['name' => Permissions::UPDATE_USERS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($updatePermission);
        $adminUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($adminUser);

        $user = factory(User::class)->create();

        $name = $this->faker->firstName;
        $enable = $this->faker->boolean;
        $email = $this->faker->email;

        $response = $this->patch(route('admin.users.update', [
            'user' => $user->id,
            'name' => $name,
            'enable' => $enable,
            'email' => $email
        ]));

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseCount('users', 2);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'enable' => $enable,
            'email' => $email
        ]);
    }

    /**
     * @test
     */
    public function superCanUpdateUsers()
    {
        Permission::create(['name' => Permissions::UPDATE_USERS]);
        $superRole = Role::create(['name' => PlatformRoles::SUPER]);
        $superUser = factory(User::class)->create()->assignRole($superRole);
        $this->actingAs($superUser);

        $user = factory(User::class)->create();

        $name = $this->faker->firstName;
        $enable = $this->faker->boolean;
        $email = $this->faker->email;

        $response = $this->patch(route('admin.users.update', [
            'user' => $user->id,
            'name' => $name,
            'enable' => $enable,
            'email' => $email
        ]));

        $response->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseCount('users', 2);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'enable' => $enable,
            'email' => $email
        ]);
    }
}
