<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientBankRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'ifsc_code' => 'required|string|max:11|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/',
            'account_number' => 'required|string|max:20',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'bank_code' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
        ];
    }
}
