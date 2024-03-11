<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTelegramFolderController extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|numeric|unique:folders,id|max:18446744073709551615',
            'name' => 'required|max:255',
            'client_id' => 'required|numeric|max:16',
            'client_name' => 'required|max:255',
            'user_name' => 'required|max:255',
        ];
    }
}
