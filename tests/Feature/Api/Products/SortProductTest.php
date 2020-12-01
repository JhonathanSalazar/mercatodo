<?php

namespace Tests\Feature\Api\Products;

use App\Entities\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SortProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function itCanSortProductByNameAsc()
    {
        factory(Product::class)->create(['name' => 'C Name']);
        factory(Product::class)->create(['name' => 'A Name']);
        factory(Product::class)->create(['name' => 'B Name']);

        $url = route('api.v1.products.index', [
            'sort' => 'name'
        ]);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'A Name',
            'B Name',
            'C Name',
        ]);
    }

    /**
     * @test
     */
    public function itCanSortProductByNameDesc()
    {
        factory(Product::class)->create(['name' => 'C Name']);
        factory(Product::class)->create(['name' => 'A Name']);
        factory(Product::class)->create(['name' => 'B Name']);

        $url = route('api.v1.products.index', [
            'sort' => '-name'
        ]);

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'C Name',
            'B Name',
            'A Name',
        ]);
    }

    /**
     * @test
     */
    public function itCanSortProductByNameAndBranch()
    {
        factory(Product::class)->create([
            'name' => 'C Name',
            'branch' => 'B branch'
        ]);
        factory(Product::class)->create([
            'name' => 'A Name',
            'branch' => 'C branch'
        ]);
        factory(Product::class)->create([
            'name' => 'B Name',
            'branch' => 'A branch'
        ]);

        $url = route('api.v1.products.index') . '?sort=name,branch';

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'A Name',
            'B Name',
            'C Name',
        ]);

        $url = route('api.v1.products.index') . '?sort=-branch,name';

        $this->jsonApi()->get($url)->assertSeeInOrder([
            'C branch',
            'B branch',
            'A branch',
        ]);
    }

    /**
     * @test
     */
    public function itCannotSortProductByUnknownsFields()
    {
        factory(Product::class,3)->create();

        $url = route('api.v1.products.index') . '?sort=unknown';

        $this->jsonApi()->get($url)->assertStatus(400);
    }

}
