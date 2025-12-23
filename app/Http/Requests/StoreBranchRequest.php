<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBranchRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:15'],
            'whatsapp_no' => ['required', 'string', 'max:15'],
            'email' => ['required', 'email', 'max:255'],
            'contact_person' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'res_pincode' => ['required', 'string', 'max:6'],
            'code' => ['required', 'string', 'max:50', Rule::unique('branches')->ignore($this->branch)],
            'gumasta' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Branch name is required.',
            'address.required' => 'Branch address is required.',
            'code.required' => 'Branch code is required.',
            'code.unique' => 'This branch code is already taken.',
            'email.email' => 'Please provide a valid email address.',
        ];
    }
}
