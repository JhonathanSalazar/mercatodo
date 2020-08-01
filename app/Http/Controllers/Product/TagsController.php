<?php

namespace App\Http\Controllers\Product;

use App\Tag;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * @param Tag $tag
     * @return View
     */
    public function show(Tag $tag): View
    {
        $products = $tag->products;

        return view('product.list', compact('products'));
    }
}
