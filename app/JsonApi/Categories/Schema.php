<?php

namespace App\JsonApi\Categories;

use App\Entities\Category;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'categories';

    /**
     * @param Category $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource): string
    {
        return (string) $resource->getRouteKey();
    }

    /**
     * @param Category $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource): array
    {
        return [
            'name' => $resource->name,
            'url' => $resource->url,
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
    public function getRelationships($category, $isPrimary, array $includeRelationships): array
    {
        return [
            'products' => [
                self::SHOW_RELATED => true,
                self::SHOW_SELF => true,
                self::SHOW_DATA => isset($includeRelationships['products']),
                self::DATA => function () use ($category) {
                    return $category->products;
                }
            ]
        ];
    }
}
