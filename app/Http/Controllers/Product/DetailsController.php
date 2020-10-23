<?php

namespace App\Http\Controllers\Product;

use App\Entities\Product;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

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
