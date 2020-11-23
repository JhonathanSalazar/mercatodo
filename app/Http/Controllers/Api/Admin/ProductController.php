<?php

namespace App\Http\Controllers\Api\Admin;

use App\Entities\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResourceCollection;
use App\Http\Resources\ResourceObject;

class ProductController extends Controller
{

    /**
     * Return the models via API.
     *
     * @return ResourceCollection
     */
    public function index(): ResourceCollection
    {
        $products = Product::applySorts()->jsonPaginate();

        return ResourceCollection::make($products);
    }

    /**
     * Return a specific model via API.
     *
     * @param Product $product
     * @return ResourceObject
     */
    public function show(Product $product): ResourceObject
    {
        return ResourceObject::make($product);
    }


}
