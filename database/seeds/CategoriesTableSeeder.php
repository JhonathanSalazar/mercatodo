<?php

use App\Entities\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run(): void
    {
        Category::truncate();

        $defaultCategory = new Category;
        $defaultCategory->name = 'Ultima Temporada';
        $defaultCategory->url = Str::slug('Ultima Temporada');
        $defaultCategory->save();

        $topProductCategory = new Category;
        $topProductCategory->name = 'Productos Caracteristicos';
        $topProductCategory->url = Str::slug('Productos Caracteristicos');
        $topProductCategory->save();

        $lastProductCategory = new Category;
        $lastProductCategory->name = 'Ultimos Productos';
        $lastProductCategory->url = Str::slug('Ultimos Productos');
        $lastProductCategory->save();

        $lastProductCategory = new Category;
        $lastProductCategory->name = 'Temporada Pasada';
        $lastProductCategory->url = Str::slug('Temporada Pasada');
        $lastProductCategory->save();
    }
}
