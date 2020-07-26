<?php

use App\Tag;
use App\Product;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();
        Tag::truncate();


        $product1 = factory(Product::class)->create();
        $product1->tags()->attach(Tag::create(['name' => 'Sin etiqueta']));

        $product2 = factory(Product::class)->create();
        $product2->tags()->attach(Tag::create(['name' => 'Mujer']));

        $product3 = factory(Product::class)->create();
        $product3->tags()->attach(Tag::create(['name' => 'Hombre']));

        $product4 = factory(Product::class)->create();
        $product4->tags()->attach(Tag::create(['name' => 'Ropa']));

        $product5 = factory(Product::class)->create();
        $product5->tags()->attach(Tag::create(['name' => 'Zapatos']));
    }
}
