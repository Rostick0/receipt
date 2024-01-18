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
            'dateTime' => 'nullable|date',
            'cashTotalSum' => 'nullable|numeric',
            'creditSum' => 'nullable|numeric',
            'ecashTotalSum' => 'nullable|numeric',
            'code' => 'nullable|max:255',
            'fiscalDocumentFormatVer' => 'nullable|max:255',
            'fiscalDocumentNumber' => 'required|numeric',
            'fiscalDriveNumber' => 'required|numeric',
            'fiscalSign' => 'required|numeric',
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
            'taxationType' => 'required|' . Rule::exists('taxation_types', 'id'),
            'user' => 'required|max:255',
            'userInn' => 'required|max:255',
            'okved_id' => 'nullable|' . Rule::exists('okveds', 'id'),
        ];
    }
}
