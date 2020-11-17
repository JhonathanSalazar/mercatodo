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
    public function aAdminCanImportProduct()
    {
        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        $this->actingAs($admUser);

        $importFile = $this->getFile('products-import-file.xlsx');
        $response = $this->post($this->getRoute(), ['productsImport' => $importFile]);

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
        $response = $this->post($this->getRoute(), ['productsImport' => $importFile]);

        $response->assertViewIs('admin.products.import.errors')
        ->assertSee('El campo nombre es obligatorio.')
        ->assertSee('El campo marca es obligatorio.')
        ->assertSee('El campo descripcion es obligatorio.')
        ->assertSee('El campo id_categoria es obligatorio.')
        ->assertSee('El campo precio es obligatorio.');

        $this->assertDatabaseCount('products', 0);

    }

    /**
     * @return string
     */
    private function getRoute(): string
    {
        return route('admin.products.import');
    }

    /**
     * @param string $filename
     * @return UploadedFile
     */
    private function getFile(string $filename): UploadedFile
    {
        $filePath = base_path('tests/Stubs/' . $filename);
        return new UploadedFile($filePath, $filename, null, null, true);
    }
}
