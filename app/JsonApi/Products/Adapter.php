<?php

namespace App\JsonApi\Products;

use App\Entities\Product;
use CloudCreativity\LaravelJsonApi\Eloquent\AbstractAdapter;
use CloudCreativity\LaravelJsonApi\Eloquent\BelongsTo;
use CloudCreativity\LaravelJsonApi\Pagination\StandardStrategy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Adapter extends AbstractAdapter
{

    protected $fillable = [
        'name',
        'description',
        'branch',
        'price',
        'ean',
        'category_id'
    ];

    protected $includePaths = [
        'categories' => 'category'
    ];

    /**
     * Mapping of JSON API attribute field names to model keys.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Mapping of JSON API filter names to model scopes.
     *
     * @var array
     */
    protected $filterScopes = [];

    /**
     * Adapter constructor.
     *
     * @param StandardStrategy $paging
     */
    public function __construct(StandardStrategy $paging)
    {
        parent::__construct(new Product(), $paging);
    }

    /**
     * @param Builder $query
     * @param Collection $filters
     * @return void
     */
    protected function filter($query, Collection $filters): void
    {
        $this->filterWithScopes($query, $filters);
    }

    /**
     * @param Model $product
     * @param Collection $attributes
     */
    protected function fillAttributes($product, Collection $attributes): void
    {
        $product->fill($attributes->only($this->fillable)->toArray());
        $product->user_id = auth()->id();
    }

    /**
     * Return the category relationship adapted.
     *
     * @return BelongsTo
     */
    public function categories()
    {
        return $this->belongsTo('category');
    }

}
