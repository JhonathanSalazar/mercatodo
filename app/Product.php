<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Return the relation product->category and category->product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return the relation product->tags and tags->product
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($product){
            Storage::delete($product->image);
            $product->tags()->detach();
        });
    }

    /**
     * Return the featured products published
     * @param Builder $query
     */
    public function scopeFeaturedHome(Builder $query)
    {
        $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->where('category_id', 2)
            ->limit(4);
    }
}
