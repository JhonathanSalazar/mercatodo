<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $search = request('q');

        $products = Product::search($search)->paginate();

        if (request()->expectsJson()) {
            return $products;
        }

        return view('product.list', compact('products'));
    }
}
