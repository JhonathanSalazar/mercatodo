<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    protected $dates = ['published_at'];

    /**
     * Create the product route show
     */
    public function path()
    {
        return "/admin/products/{$this->id}";
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
