<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReceiptUploaderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() || $this->chat_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'upload' => 'required|file|mimes:json',
            'chat_id' => 'nullable|numeric|' . Rule::exists('user_telegrams', 'telegram_user_id'),
            'folder_id' => 'nullable|' . Rule::exists('folders', 'id'),
        ];
    }
}
