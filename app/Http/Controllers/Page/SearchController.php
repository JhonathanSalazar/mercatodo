<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $search = request('q');

        $products = Product::search($search)->paginate();

        if (request()->expectsJson()) {
            return $products;
        }

        return view('product.list', compact('products'));
    }
}
