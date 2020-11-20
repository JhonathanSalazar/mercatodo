<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{

    public $collects = ProductResource:: class;

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => route('api.v1.products.index')
            ],
            'meta' => [
                'products_count' => $this->collection->count()
            ]
        ];
    }
}
