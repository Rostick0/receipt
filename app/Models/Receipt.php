<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'dateTime',
        'cashTotalSum',
        'creditSum',
        'ecashTotalSum',
        'code',
        'fiscalDocumentFormatVer',
        'fiscalDocumentNumber',
        'fiscalDriveNumber',
        'fiscalSign',
        'kktRegId',
        'nds0',
        'ndsNo',
        'nds10',
        'nds18',
        'operationType',
        'prepaidSum',
        'provisionSum',
        'requestNumber',
        'retailPlace',
        'retailPlaceAddress',
        'shiftNumber',
        'operator',
        'taxationType',
        'totalSum',
        'user',
        'userInn',
        'user_id',
        'okved_id',
    ];

    protected $casts = [
        'dateTime' => 'datetime',
        'fiscalDriveNumber' => 'string',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function okved()
    {
        return $this->belongsTo(Okved::class);
    }

    public function operationTypeCollection() {
        return $this->belongsTo(OperationType::class, 'operationType');
    }

    public function taxationTypeCollection() {
        return $this->belongsTo(TaxationType::class, 'taxationType');
    }

    public function folder_receipts() {
        return $this->hasMany(FolderReceipt::class);
    }
}
