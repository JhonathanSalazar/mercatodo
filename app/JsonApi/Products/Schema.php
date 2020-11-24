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

    /**
     * Return the relationship in category->products in the API.
     *
     * @param object $category
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array|array[]
     */
    public function getRelationships($product, $isPrimary, array $includeRelationships)
    {
        return [
            'categories' => [
                self::SHOW_RELATED => true,
                self::SHOW_SELF => true,
                self::SHOW_DATA => isset($includeRelationships['categories']),
                self::DATA => function() use ($product) {
                    return $product->category;
                }
            ]
        ];
    }
}
