<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\Receipt;

class ProductObserver
{
    private static function receiptTotalSume(int $receipt_id)
    {
        $receipt = Receipt::find($receipt_id);
// 
        $receipt->update([
            'totalSum' => $receipt->products->sum('sum')
        ]);
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $this::receiptTotalSume($product->receipt_id);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        $this::receiptTotalSume($product->receipt_id);
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        $this::receiptTotalSume($product->receipt_id);
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
