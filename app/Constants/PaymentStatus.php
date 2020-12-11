<?php


namespace App\Constants;

class PaymentStatus
{
    /**
     * Orders status constants.
     */
    public const APPROVED = 'APPROVED';
    public const PENDING = 'PENDING';
    public const REJECTED = 'REJECTED';

    const TYPES = [
        self::APPROVED,
        self::PENDING,
        self::REJECTED
    ];
}
