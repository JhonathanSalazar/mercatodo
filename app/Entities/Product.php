<?php

namespace App\Entities;

use App\Constants\PaymentStatus;
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
     *
     * @return string
     */
    public function showUrl(): string
    {
        return "/admin/products/{$this->id}";
    }

    /**
     * Returns the attributes required in the API.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            'name' => $this->name,
            'ean' => (string)$this->ean,
            'branch' => $this->branch,
            'price' => (string)$this->price,
            'description' => $this->description
        ];
    }

    /**
     * Return the relation product->category and category->product
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Return the relation product->tags and tags->product
     *
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($product) {
            Storage::delete($product->image);
            $product->tags()->detach();
        });
    }

    /**
     * Return the featured products published
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeFeaturedHome(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->where('category_id', '=', 2)
            ->orderBy('published_at', 'desc')
            ->limit(4);
    }

    /**
     * Return the last products published
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeLastHome(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', Carbon::now())
            ->where('category_id', '=', 3)
            ->orderBy('published_at', 'desc')
            ->with('category')
            ->limit(4);
    }

    /**
     * Return the scope to a specific category.
     *
     * @param Builder $query
     * @param string $values
     * @return Builder
     */
    public function scopeCategories(Builder $query, string $values): Builder
    {
        return $query->whereHas('category', function ($q) use ($values) {
            $q->whereIn('url', explode(',', $values));
        });
    }

    /**
     * Get the url attribute correctly.
     *
     * @return string
     */
    public function getImageUrlAttribute(): string
    {

        if ($this->image == null) {
            return "/storage/images/default.jpeg";
        }

        return "/storage/" . $this->image;
    }

}
