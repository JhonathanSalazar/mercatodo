<?php

namespace App\Http\Controllers\Product;


use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    /**
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        $products = $category->products;

        return view('product.list', compact('products'));
    }
}
