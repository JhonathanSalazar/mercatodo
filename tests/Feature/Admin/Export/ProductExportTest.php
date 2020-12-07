<?php

namespace Tests\Feature\Admin\Export;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\Product;
use App\Entities\User;
use App\Exports\ProductExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductExportTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantExportProducts()
    {
        factory(Product::class, 10)->create();
        Excel::fake();

        $this->get($this->getExportRoute())
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function aBuyerUserCannotExportProducts()
    {
        $buyerRole = Role::create(['name' => PlatformRoles::BUYER]);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        factory(Product::class, 10)->create();
        Excel::fake();

        $this->actingAs($buyerUser)->get($this->getExportRoute())
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function anAdminWithoutPermissionCantQueueProductExport()
    {
        $filePathTest = '/products-\d{4}\-\d{2}\-\d{2}\_\d{2}\-\d{2}\.xlsx/';
        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm');
        $filePath = 'exports/products-' . $now . '.xlsx';

        Permission::create(['name' => Permissions::EXPORT]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        factory(Product::class, 10)->create();
        Excel::fake();

        $this->actingAs($admUser)->from($this->getIndexRoute())
            ->get($this->getExportRoute())
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function anAdminWithPermissionCanQueueProductExport()
    {
        $filePathTest = '/products-\d{4}\-\d{2}\-\d{2}\_\d{2}\-\d{2}\.xlsx/';
        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm');
        $filePath = 'exports/products-' . $now . '.xlsx';

        $exportPermission = Permission::create(['name' => Permissions::EXPORT]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($exportPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        factory(Product::class, 10)->create();
        Excel::fake();

        $this->actingAs($admUser)->from($this->getIndexRoute())
            ->get($this->getExportRoute())
            ->assertRedirect($this->getIndexRoute());

        Excel::matchByRegex();

        Excel::assertStored($filePathTest);

        Excel::assertQueued(
            $filePathTest,
            function (ProductExport $export) {
                return true;
            }
        );

        Excel::assertQueuedWithChain([
            new NotifyUserOfCompletedExport($admUser, $filePath)
        ]);
    }

    /**
     * Return the products export route.
     *
     * @return string
     */
    private function getExportRoute(): string
    {
        return route('admin.products.export');
    }

    /**
     * Return the products index route.
     *
     * @return string
     */
    private function getIndexRoute(): string
    {
        return route('admin.products.index');
    }
}
