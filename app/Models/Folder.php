<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Folder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'user_id',
        'client_id',
        'client_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder_receipts()
    {
        return $this->hasMany(FolderReceipt::class);
    }
}
