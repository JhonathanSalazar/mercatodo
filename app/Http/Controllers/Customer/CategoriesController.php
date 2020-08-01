<?php

namespace App\Http\Controllers\Customer;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category)
    {
        $products = $category->products;

        return view('product.list', compact('products'));
    }
}
