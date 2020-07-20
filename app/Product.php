<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    /*
     * Create the product route show
     */
    public function path()
    {
        return "/admin/products/{$this->id}";
    }
}
