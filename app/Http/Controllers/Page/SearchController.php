<?php

namespace App\Http\Controllers\Page;

use App\Entities\Product;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $search = request('q');
        $products = Product::search($search)->paginate();

        return view('product.list', compact('products'));
    }
}
