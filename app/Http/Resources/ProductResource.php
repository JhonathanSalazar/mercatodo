<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'products',
            'id' => (string)$this->resource->getRouteKey(),
            'attributes' => [
                'name' => $this->resource->name,
                'ean' => (string)$this->resource->ean,
                'branch' => $this->resource->branch,
                'price' => (string)$this->resource->price,
                'description' => $this->resource->description
            ],
            'links' => [
                'self' => route('api.v1.products.show', $this->resource)
            ]
        ];
    }
}
