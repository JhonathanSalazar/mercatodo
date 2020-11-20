<?php

namespace App\Http\Controllers\Api\Admin;

use App\Entities\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{


    public function index()
    {
        return ProductCollection::make(Product::all());
    }

    /**
     * Return a specific model via API.
     *
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product): ProductResource
    {
        return ProductResource::make($product);
    }


}
