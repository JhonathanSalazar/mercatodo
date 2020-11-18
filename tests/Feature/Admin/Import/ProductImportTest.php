<?php

namespace Tests\Feature\Admin\Import;

use App\Entities\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
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
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        $this->actingAs($buyerUser);

        $this->post($this->getImportRoute())
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function aAdminCanImportProduct()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $importFile = $this->getFile('products-import-file.xlsx');
        $response = $this->post($this->getImportRoute(), ['productsImport' => $importFile]);

        $response->assertRedirect(route('admin.products.index'));
        $this->assertDatabaseHas('products', [
            'ean' => '1234562789',
            'name' => 'Fake Name',
            'branch' => 'Fake Branch',
            'description' => 'A fake description',
            'price' => 999999
        ]);
    }

    /**
     * @test
     */
    public function itCannotImportProductDueValidationError()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $importFile = $this->getFile('products-not-validate-import-file.xlsx');
        $response = $this->post($this->getImportRoute(), ['productsImport' => $importFile]);

        $response->assertViewIs('admin.products.import.errors')
            ->assertSee('El campo nombre es obligatorio.')
            ->assertSee('El campo marca es obligatorio.')
            ->assertSee('El campo descripcion es obligatorio.')
            ->assertSee('El campo id_categoria es obligatorio.')
            ->assertSee('El campo precio es obligatorio.');

        $this->assertDatabaseCount('products', 0);

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
