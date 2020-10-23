<?php

namespace App\Http\Controllers\Product;

use App\Entities\Tag;
use Illuminate\View\View;
use App\Http\Controllers\Controller;

class TagsController extends Controller
{
    /**
     * @param Tag $tag
     * @return View
     */
    public function show(Tag $tag): View
    {
        $products = $tag->products()->paginate(5);

        return view('product.list', compact('products'));
    }
}
