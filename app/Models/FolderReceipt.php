<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FolderReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'receipt_id',
        'folder_id',
        'comment',
    ];

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }
}
