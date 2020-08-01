<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
