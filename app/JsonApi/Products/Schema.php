<?php

namespace App\JsonApi\Products;

use App\Entities\Product;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'products';

    /**
     * @param Product $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string)$resource->getRouteKey();
    }

    /**
     * @param Product $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($product)
    {
        return [
            'name' => $product->name,
            'ean' => (string)$product->ean,
            'branch' => $product->branch,
            'price' => (string)$product->price,
            'description' => $product->description,
            'created-at' => $product->created_at->toAtomString(),
            'updated-at' => $product->updated_at->toAtomString()
        ];
    }
}
