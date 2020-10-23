<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
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
}
