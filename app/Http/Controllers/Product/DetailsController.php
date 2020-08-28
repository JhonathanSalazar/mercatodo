<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DetailsController extends Controller
{
    /**
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        return view('product.details', compact('product'));
    }
}
