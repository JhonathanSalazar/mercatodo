<?php


namespace App\Constants;

class Reports
{
    public const SOLD_PRODUCTS = 'sold_products';
    public const ORDERS_CREATED = 'orders_created';

    /**
     * Reports types constant.
     */
    const TYPES = [
        self::SOLD_PRODUCTS,
        self::ORDERS_CREATED
    ];
}
