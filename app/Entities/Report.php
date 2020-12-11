<?php

namespace App\Entities;

use App\Classes\PaymentStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'type',
        'file_path',
        'created_by',
    ];

    /**
     * Relation belong to Users
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the report file route correctly.
     *
     * @return string
     */
    public function getFileRoute(): string
    {
        return '/storage/' . $this->file_path;
    }

}
