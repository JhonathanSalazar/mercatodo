<?php

namespace App\Models;

use Carbon\Carbon;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use Searchable, SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string[]
     */
    protected $dates = ['published_at'];

    /**
     * Create the product route show
     * @return string
     */
    public function showUrl(): string
    {
        return "/admin/products/{$this->id}";
    }

    /**
     * Return the relation product->category and category->product
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return the relation product->tags and tags->product
     * @return BelongsToMany
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
