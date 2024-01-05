<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReceiptRequest extends FormRequest
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
            'dateTime' => 'nullable',
            'cashTotalSum' => 'nullable',
            'creditSum' => 'nullable',
            'ecashTotalSum' => 'nullable',
            'code' => 'nullable|max:255',
            'fiscalDocumentFormatVer' => 'nullable|max:255',
            'fiscalDocumentNumber' => 'required|max:255',
            'fiscalDriveNumber' => 'required|max:255',
            'fiscalSign' => 'required|max:255',
            'kktRegId' => 'required|max:255',
            'nds0' => 'nullable|max:255',
            'ndsNo' => 'nullable',
            'nds10' => 'nullable',
            'nds20' => 'nullable',
            'operationType' => 'required',
            'prepaidSum' => 'nullable',
            'provisionSum' => 'nullable',
            'requestNumber' => 'nullable',
            'retailPlace' => 'nullable|max:255',
            'retailPlaceAddress' => 'nullable|max:255',
            'shiftNumber' => 'nullable',
            'taxationType' => 'required',
            'user' => 'required|max:255',
            'userInn' => 'required|max:255',
            'okved_id' => 'required|' . Rule::exists('okveds', 'id'),
        ];
    }
}
