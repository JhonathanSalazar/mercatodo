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
        $this->withoutExceptionHandling();
        config(['scout.driver' => 'algolia']);

        $adminRole = Role::create(['name' => 'Admin']);
        factory(User::class)->create()->assignRole($adminRole);

        $search = 'foobar';

        factory(Product::class)->create([
            'description' => "A product with the {$search} term."
        ]);
        factory(Product::class)->create([
                'name' => 'falseName',
                'branch' => 'falseBranch',
                'description' => 'a false description'
            ]);

        do {
            sleep(2);

            $results = $this->getJson("/search?q={$search}")->json()['data'];
        } while( empty($results));

        $this->assertCount(2, $results);

        Product::latest()->take(3)->unsearchable();
    }
}
