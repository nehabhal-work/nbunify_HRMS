<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestmentSiRequest extends FormRequest
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
            'investment_id' => 'required|exists:investments,id',
            'si_number' => 'required|string|max:255|unique:investment_si,si_number,' . $this->route('si'),
            'bank_reference_no' => 'nullable|string|max:255',
            'instruction_type' => 'required|in:standing,schedule',
            'si_client_bank_id' => 'required|exists:client_banks,id',
            'si_company_bank_id' => 'required|exists:company_bank_details,id',
            'si_start_date' => 'required|date',
            'si_amount' => 'required|numeric|min:0',
            'si_no_of_payments' => 'required|integer|min:1',
            'attachment_si_image' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'attachment_notes_image' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'status' => 'nullable|in:active,inactive',
            'remarks' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'investment_id.required' => 'Please select an investment.',
            'investment_id.exists' => 'Selected investment does not exist.',
            'si_number.required' => 'SI Number is required.',
            'si_number.unique' => 'This SI Number already exists.',
            'instruction_type.required' => 'Instruction type is required.',
            'instruction_type.in' => 'Instruction type must be either standing or schedule.',
            'si_client_bank_id.required' => 'Please select a client bank.',
            'si_company_bank_id.required' => 'Please select a company bank.',
            'si_start_date.required' => 'SI Start Date is required.',
            'si_amount.required' => 'SI Amount is required.',
            'si_amount.min' => 'SI Amount must be greater than 0.',
            'si_no_of_payments.required' => 'Number of payments is required.',
            'si_no_of_payments.min' => 'Number of payments must be at least 1.',
            'remarks.max' => 'Remarks may not be greater than 255 characters.',
        ];
    }
}
