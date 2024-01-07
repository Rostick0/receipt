<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxationType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
}
