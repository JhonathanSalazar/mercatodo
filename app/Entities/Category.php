<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    protected $guarded = [];

    /**
     * Change the keyName to reference.
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'url';
    }

    /**
     * Return the Collection of relation category->products.
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * @return Collection
     */
    public static function getCategoryFromCache(): Collection
    {
        return Cache::rememberForever('categories', function () {
            return Category::select('id', 'name', 'url')->get();
        });
    }
}
