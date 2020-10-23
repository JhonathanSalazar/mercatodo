<?php

namespace App\Http\Controllers\Product;

use App\Entities\Category;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class CategoriesController extends Controller
{
    /**
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        $products = $category->products()->paginate(5);

        return view('product.list', compact('products'));
    }
}
