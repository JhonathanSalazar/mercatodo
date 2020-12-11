<?php

namespace App\Observers;

use App\Entities\Product;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    /**
     * Handle the products "created" event.
     *
     * @param Product $product
     * @return void
     */
    public function created(Product $product): void
    {
        Log::notice('The user ' . $product->user_id . ' has created the product with id ' . $product->id);
    }

    /**
     * Handle the products "updated" event.
     *
     * @param Product $product
     * @return void
     */
    public function updated(Product $product): void
    {
        Log::notice('The product with id ' . $product->id . 'has been updated.');
    }

    /**
     * Handle the products "deleted" event.
     *
     * @param Product $product
     * @return void
     */
    public function deleted(Product $product)
    {
        Log::notice('The product with id ' . $product->id . 'has been deleted.');
    }
}
