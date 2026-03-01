<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmountsReceiptNds extends Model
{
    use HasFactory;

    protected $fillable = [
        'nds',
        'ndsSum',
        'receipt_id'
    ];

    public function receipt(): BelongsTo
    {
        return $this->belongsTo(Receipt::class);
    }

    public function ndsSum(): Attribute
    {
        return Attribute::make(
            get: fn(int $value) => $value / 100,
        );
    }
}
