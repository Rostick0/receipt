<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReceiptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            '_id' => 'nullable|max:255',
            'dateTime' => 'nullable|date',
            'cashTotalSum' => 'nullable|numeric',
            'creditSum' => 'nullable|numeric',
            'ecashTotalSum' => 'nullable|numeric',
            'code' => 'nullable|numeric|digits_between:1,20',
            'fiscalDocumentFormatVer' => 'nullable|numeric|digits_between:1,20',
            'fiscalDocumentNumber' => 'required|numeric|digits_between:1,20',
            'fiscalDriveNumber' => 'required|numeric|digits_between:1,20',
            'fiscalSign' => 'required|numeric|digits_between:1,20',
            'kktRegId' => 'required|max:255',
            'nds0' => 'nullable|numeric',
            'ndsNo' => 'nullable|numeric',
            'nds10' => 'nullable|numeric',
            'nds18' => 'nullable|numeric',
            'operationType' => 'required|' . Rule::exists('operation_types', 'id'),
            'prepaidSum' => 'nullable|numeric',
            'provisionSum' => 'nullable|numeric',
            'requestNumber' => 'nullable|numeric',
            'retailPlace' => 'nullable|max:255',
            'retailPlaceAddress' => 'nullable|max:255',
            'shiftNumber' => 'nullable|numeric',
            'operator'  => 'nullable|max:255',
            'taxationType' => 'required|' . Rule::exists('taxation_types', 'id'),
            'user' => 'nullable|max:255',
            'userInn' => 'required|max:255',
            'okved_id' => 'nullable|' . Rule::exists('okveds', 'id'),
        ];
    }
}
