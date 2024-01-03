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
        'nds20',
        'operationType',
        'prepaidSum',
        'provisionSum',
        'requestNumber',
        'retailPlace',
        'retailPlaceAddress',
        'shiftNumber',
        'taxationType',
        'totalSum',
        'user',
        'userInn',
        'user_id',
        'okved_id',
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
        return $this->belongsTo(Collection::class)->where('operation_type');
    }
}
