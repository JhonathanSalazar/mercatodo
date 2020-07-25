<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        $defaultCategory = new Category;
        $defaultCategory->name = 'Sin categoria';
        $defaultCategory->save();

        $topProductCategory = new Category;
        $topProductCategory->name = 'Productos Caracteristicos';
        $topProductCategory->save();

        $lastProductCategory = new Category;
        $lastProductCategory->name = 'Ultimos Productos';
        $lastProductCategory->save();

    }
}
