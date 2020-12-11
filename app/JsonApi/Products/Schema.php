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
    public function getId($resource): string
    {
        return (string)$resource->getRouteKey();
    }

    /**
     * @param $product
     * @return array
     */
    public function getAttributes($product): array
    {
        return [
            'name' => $product->name,
            'ean' => (string)$product->ean,
            'branch' => $product->branch,
            'price' => (string)$product->price,
            'description' => $product->description,
            'category_id' => $product->category_id,
            'created-at' => $product->created_at->toAtomString(),
            'updated-at' => $product->updated_at->toAtomString()
        ];
    }

    /**
     * Return the relationship in category->products in the API.
     *
     * @param $product
     * @param bool $isPrimary
     * @param array $includeRelationships
     * @return array|array[]
     */
    public function getRelationships($product, $isPrimary, array $includeRelationships): array
    {
        return [
            'categories' => [
                self::SHOW_RELATED => true,
                self::SHOW_SELF => true,
                self::SHOW_DATA => isset($includeRelationships['categories']),
                self::DATA => function () use ($product) {
                    return $product->category;
                }
            ]
        ];
    }
}
