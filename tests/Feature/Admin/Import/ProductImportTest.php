<?php

namespace Tests\Feature\Admin\Import;

use App\Constants\Permissions;
use App\Constants\PlatformRoles;
use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductImportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guestCantImportProducts()
    {
        $this->post($this->getImportRoute())
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function aBuyerCantImportProducts()
    {
        $buyerRole = Role::create(['name' => PlatformRoles::BUYER]);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $this->post($this->getImportRoute())
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function aAdminWithoutPermissionCantImportProduct()
    {
        Permission::create(['name' => Permissions::IMPORT]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN]);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $importFile = $this->getFile('products-import-file.xlsx');
        $this->post($this->getImportRoute(), ['productsImport' => $importFile])
        ->assertStatus(403);
    }

    /**
     * @test
     */
    public function aAdminWithPermissionCanImportProduct()
    {
        $importPermission = Permission::create(['name' => Permissions::IMPORT]);
        $adminRole = Role::create(['name' => PlatformRoles::ADMIN])->givePermissionTo($importPermission);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        Excel::fake();

        $importFile = $this->getFile('products-import-file.xlsx');
        $this->post($this->getImportRoute(), ['productsImport' => $importFile]);

        Excel::assertQueued($importFile->getFilename());
    }

    /**
     * Return the products import route.
     *
     * @return string
     */
    private function getImportRoute(): string
    {
        return route('admin.products.import');
    }

    /**
     * Return the UploadedFile.
     *
     * @param string $filename
     * @return UploadedFile
     */
    private function getFile(string $filename): UploadedFile
    {
        $filePath = base_path('tests/Stubs/' . $filename);
        return new UploadedFile($filePath, $filename, null, null, true);
    }
}
