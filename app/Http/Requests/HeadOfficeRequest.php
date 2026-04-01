<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class HeadOfficeRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'fax' => 'nullable|string|max:20',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'pincode' => 'nullable|string|max:20',
            'timezone' => 'nullable|string|max:60',
            'currency' => 'nullable|string|max:10',
            'manager_name' => 'nullable|string',
            'manager_email' => 'nullable|email',
            'established_at' => 'nullable|date',
            'is_active' => 'boolean',
            'meta' => 'nullable|array',
        ];
    }
}
