<?php

namespace App\Observers;

use App\Models\AmountsReceiptNds;

class AmountsReceiptNdsObserver
{
    /**
     * Handle the AmountsReceiptNds "created" event.
     */
    public function created(AmountsReceiptNds $amountsReceiptNds): void
    {
        if ($amountsReceiptNds->nds == 1) {
            $amountsReceiptNds->receipt()->update([
                'nds18' => $amountsReceiptNds->ndsSum * 100,
            ]);

            $amountsReceiptNds->delete();
        }

        if ($amountsReceiptNds->nds == 2) {
            $amountsReceiptNds->receipt()->update([
                'nds10' => $amountsReceiptNds->ndsSum * 100,
            ]);

            $amountsReceiptNds->delete();
        }

        if ($amountsReceiptNds->nds == 6) {
            $amountsReceiptNds->receipt()->update([
                'ndsNo' => $amountsReceiptNds->ndsSum * 100,
            ]);

            $amountsReceiptNds->delete();
        }

        if ($amountsReceiptNds->nds == 5) {
            $amountsReceiptNds->receipt()->update([
                'nds0' => $amountsReceiptNds->ndsSum * 100,
            ]);

            $amountsReceiptNds->delete();
        }
    }

    /**
     * Handle the AmountsReceiptNds "updated" event.
     */
    public function updated(AmountsReceiptNds $amountsReceiptNds): void
    {
        //
    }

    /**
     * Handle the AmountsReceiptNds "deleted" event.
     */
    public function deleted(AmountsReceiptNds $amountsReceiptNds): void
    {
        //
    }

    /**
     * Handle the AmountsReceiptNds "restored" event.
     */
    public function restored(AmountsReceiptNds $amountsReceiptNds): void
    {
        //
    }

    /**
     * Handle the AmountsReceiptNds "force deleted" event.
     */
    public function forceDeleted(AmountsReceiptNds $amountsReceiptNds): void
    {
        //
    }
}
