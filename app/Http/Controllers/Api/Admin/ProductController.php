<?php

namespace App\Http\Controllers\Api\Admin;

use App\Entities\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Str;

class ProductController extends Controller
{


    /**
     * Return the models via API.
     *
     * @return ProductCollection
     */
    public function index(): ProductCollection

    {
        $products = Product::applySorts(request('sort'))->get();

        return ProductCollection::make($products);
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
