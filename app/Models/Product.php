<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nds',
        'price',
        'quantity',
        'sum',
        'receipt_id',
    ];

    public function receipt() {
        return $this->belongsTo(Receipt::class);
    }
}
