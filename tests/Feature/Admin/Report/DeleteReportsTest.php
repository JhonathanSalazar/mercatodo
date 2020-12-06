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

class DeleteReportsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantDeleteReports()
    {
        $report = factory(Report::class)->create();

        $this->delete(route('admin.reports.destroy', $report))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function buyerCantDeleteReports()
    {
        $buyerUser = factory(User::class)->create();
        $this->actingAs($buyerUser);

        $report = factory(Report::class)->create();

        $this->delete(route('admin.reports.destroy', $report))
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function adminWithPermissionCanDeleteReports()
    {
        $deleteReportPermission = Permission::create(['name' => Permissions::DELETE_REPORTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($deleteReportPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $report = factory(Report::class)->create();
        $this->actingAs($admUser);

        $this->from(route('admin.reports.index'))
            ->delete(route('admin.reports.destroy', $report))
            ->assertRedirect(route('admin.reports.index'));

        $this->assertDeleted('products', $report->toArray());
    }

    /**
     * @test
     */
    public function adminWithoutPermissionCantDeleteReports()
    {
        Permission::create(['name' => Permissions::DELETE_REPORTS]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $report = factory(Report::class)->create();
        $this->actingAs($admUser);

        $this->delete(route('admin.reports.destroy', $report))
            ->assertStatus(403);
    }
}
