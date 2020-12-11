<?php

namespace App\Entities;

use Darryldecode\Cart\CartConditionCollection;
use Illuminate\Database\Eloquent\Model;

class DatabaseStorageModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'cart_storage';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'id', 'cart_data',
    ];

    /**
     * Set the Cart Data Attributes
     *
     * @param $value
     */
    public function setCartDataAttribute($value): void
    {
        $this->attributes['cart_data'] = serialize($value);
    }

    /**
     * @param $value
     * @return CartConditionCollection|array
     */
    public function getCartDataAttribute($value)
    {
        return unserialize($value);
    }
}
