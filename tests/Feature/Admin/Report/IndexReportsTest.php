<?php

namespace Tests\Feature\Admin\Report;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\Report;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class IndexReportsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantIndexReports()
    {
        factory(Report::class)->create();

        $this->get(route('admin.reports.index'))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantIndexReports()
    {
        factory(Report::class)->create();
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $response = $this->get(route('admin.products.index'));

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminRoleWithPermissionCanViewReports()
    {
        $products = factory(Report::class, 10)->create();

        $viewReportsPermission = Permission::create(['name' => Permissions::VIEW_REPORTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($viewReportsPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $response = $this->get(route('admin.reports.index'));

        $response->assertStatus(200);

        $products->each(function ($item) use ($response) {
            $response->assertSee($item->type);
        });
    }

    /**
     * @test
     */
    public function adminRoleWithoutPermissionCantIndexReports()
    {
        factory(Report::class, 10)->create();

        Permission::create(['name' => Permissions::VIEW_REPORTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $response = $this->get(route('admin.reports.index'));

        $response->assertStatus(403);
    }
}
