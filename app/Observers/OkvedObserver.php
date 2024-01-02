<?php

namespace App\Observers;

use App\Models\Okved;

class OkvedObserver
{
    /**
     * Handle the Okved "created" event.
     */
    public function created(Okved $okved): void
    {
        //
    }

    /**
     * Handle the Okved "updated" event.
     */
    public function updated(Okved $okved): void
    {
        //
    }

    /**
     * Handle the Okved "deleted" event.
     */
    public function deleted(Okved $okved): void
    {
        $okveds = Okved::where('parent_id', $okved->id);

        $okveds->update([
            'parent_id' => $okved->parent_id
        ]);
    }

    /**
     * Handle the Okved "restored" event.
     */
    public function restored(Okved $okved): void
    {
        //
    }

    /**
     * Handle the Okved "force deleted" event.
     */
    public function forceDeleted(Okved $okved): void
    {
        //
    }
}
