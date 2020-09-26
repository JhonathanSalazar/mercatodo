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
     *
     */
    public function aBuyerCanSearchProducts()
    {

        $this->withoutExceptionHandling();
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

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

}
