<?php

namespace Tests\Feature\Admin\Export;

use App\Entities\Product;
use App\Entities\User;
use App\Exports\ProductExport;
use App\Jobs\NotifyUserOfCompletedExport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
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

        $this->get(route($this->getExportRoute()))
            ->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function aBuyerUserCannotExportProducts()
    {
        $buyerRole = Role::create(['name' => 'Buyer']);
        $buyerUser = factory(User::class)->create()->assignRole($buyerRole);
        factory(Product::class, 10)->create();
        Excel::fake();

        $this->actingAs($buyerUser)->get(route($this->getExportRoute()))
            ->assertStatus(403);
    }

    /**
     * @test
     */
    public function anAdminCanQueueProductExport()
    {
        $filePathTest = '/products-\d{4}\-\d{2}\-\d{2}\_\d{2}\-\d{2}\.xlsx/';
        $now = Carbon::now()->isoFormat('YYYY-MM-DD_HH-mm');
        $filePath = 'exports/products-' . $now . '.xlsx';

        $adminRole = Role::create(['name' => 'Admin']);
        $admUser = factory(User::class)->create()->assignRole($adminRole);
        factory(Product::class, 10)->create();
        Excel::fake();

        $this->actingAs($admUser)->from(route($this->getIndexRoute()))
            ->get(route($this->getExportRoute()))
            ->assertRedirect(route($this->getIndexRoute()));

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
        return 'admin.products.export';
    }

    /**
     * Return the products index route.
     *
     * @return string
     */
    private function getIndexRoute(): string
    {
        return 'admin.products.index';
    }
}
