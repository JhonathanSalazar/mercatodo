<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use Searchable, SoftDeletes;

    protected $guarded = [];
    protected $dates = ['published_at'];

    /**
     * Create the product route show
     */
    public function showUrl(): string
    {
        return "/admin/products/{$this->id}";
    }

    /**
     * Return the relation product->category and category->product
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return the relation product->tags and tags->product
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return void
     */
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
            ->orderBy('published_at', 'desc')
            ->limit(4);
    }

    /**
     * Return the last products published
     * @param Builder $query
     */
    public function scopeLastHome(Builder $query)
    {
        $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'desc')
            ->limit(4);
    }
}
