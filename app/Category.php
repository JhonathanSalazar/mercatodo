<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * Change the keyName to reference.
     */
    public function getRouteKeyName()
    {
        return 'url';
    }

    /**
     * Return the Collection of relation category->products.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
