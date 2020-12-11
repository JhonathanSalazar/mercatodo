<?php

namespace Tests\Feature\Admin\User;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexUsersTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantIndexUsers()
    {
        factory(User::class, 5)->create();

        $response = $this->get($this->getIndexRoute());

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantIndexUsers()
    {
        factory(User::class, 5)->create();
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $response = $this->get($this->getIndexRoute());

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminRoleWithPermissionCanIndexUsers()
    {
        $users = factory(User::class, 10)->create();

        $viewUserPermission = Permission::create(['name' => Permissions::VIEW_USERS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($viewUserPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $response = $this->get($this->getIndexRoute());

        $response->assertStatus(200);

        $users->each(function ($item) use ($response) {
            $response->assertSee($item->name);
            $response->assertSee($item->email);
        });
    }

    /**
     * @test
     */
    public function adminRoleWithoutPermissionCantIndexUsers()
    {
        factory(User::class, 10)->create();

        Permission::create(['name' => Permissions::VIEW_USERS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $this->get($this->getIndexRoute())->assertStatus(403);
    }

    /**
     * Return the user index route.
     *
     * @return string
     */
    private function getIndexRoute(): string
    {
        return route('admin.users.index');
    }
}
