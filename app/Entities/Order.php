<?php

namespace App\Entities;

use App\Classes\PaymentStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;

class Order extends Model
{

    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = [
        'processUrl', 'requestID'
    ];

    /**
     * @var array
     */
    protected $dates = ['paid_at'];

    /**
     * @return BelongsToMany
     */
    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
            ->withPivot('price', 'quantity')->withTrashed();
    }

    /**
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function paymentAttempts(): HasMany
    {
        return $this->hasMany(PaymentAttempt::class);
    }

    /**
     * Get the Orders Payed.
     *
     * @param Builder $query
     */
    public function scopePayedPerDayToChart(Builder $query)
    {
        return $query
            ->where('status', '=', PaymentStatus::APPROVED)
            ->select('grand_total', 'paid_at')
            ->orderBy('paid_at', 'asc')
            ->get()
            ->groupBy(function ($val) {
                return Carbon::parse($val->paid_at)->format('Y-m-d');
            });
    }
}
