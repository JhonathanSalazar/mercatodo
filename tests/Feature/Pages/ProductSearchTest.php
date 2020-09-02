<?php

namespace Tests\Feature\Pages;

use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function aBuyerCanSearchProducts()
    {
        config(['scout.driver' => 'algolia']);

        $adminRole = Role::create(['name' => 'Admin']);
        factory(User::class)->create()->assignRole($adminRole);

        $search = 'foobar';

        $productA = factory(Product::class)->create([
            'description' => "A product with the {$search} term."
        ]);

        factory(Product::class)->create([
                'name' => 'falseName',
                'branch' => 'falseBranch',
                'description' => 'a false description'
            ]);

        do {
            sleep(1.5);

            $results = $this->get("/search?q={$search}");
        } while( empty($results));

        $products = $results->getOriginalContent()['products'];

        $this->assertEquals($products->first()->id, $productA->id);

        Product::latest()->take(2)->unsearchable();
    }
}
