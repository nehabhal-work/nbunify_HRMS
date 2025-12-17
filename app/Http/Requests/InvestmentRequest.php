<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestmentRequest extends FormRequest
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
            'investment_date' => 'required|date',
            'investment_type' => 'required|string|max:255',
            'first_client_id' => 'required|exists:clients,id',
            'second_client_id' => 'nullable|exists:clients,id',
            'third_client_id' => 'nullable|exists:clients,id',
            'fourth_client_id' => 'nullable|exists:clients,id',
            'scheme_id' => 'required|exists:schemes_master,id',
            'investment_amount' => 'required|numeric|min:0',
            'tenure_type' => 'required|string|max:255',
            'tenure_count' => 'required|integer|min:1',
            'frequency' => 'required|string|max:255',
            'roi_percent' => 'required|numeric|min:0|max:100',
            'additional_roi_percent' => 'nullable|numeric|min:0|max:100',
            'has_tds' => 'boolean',
            'attachment_tds_url' => 'nullable|string',
            'from_company_bank_id' => 'required|exists:company_bank_details,id',
            'to_client_bank_id' => 'required|exists:client_banks,id',
            
            // Input banks validation
            'input_banks' => 'nullable|array',
            'input_banks.*.from_client_bank_id' => 'required|exists:client_banks,id',
            'input_banks.*.to_company_bank_id' => 'required|exists:company_bank_details,id',
            'input_banks.*.instrument_type' => 'required|string|max:255',
            'input_banks.*.client_instrument_date' => 'required|date',
            'input_banks.*.client_reference_no' => 'nullable|string|max:255',
            'input_banks.*.amount' => 'required|numeric|min:0',
            'input_banks.*.attachment_instrument_url' => 'required|string',
            'input_banks.*.company_reference_no' => 'nullable|string|max:255',
            'input_banks.*.company_instrument_date' => 'required|date',
            
            // Nominees validation
            'nominees' => 'nullable|array',
            'nominees.*.client_family_id' => 'required|exists:client_families,id',
            'nominees.*.guardian_client_family_id' => 'required|exists:client_families,id',
            'nominees.*.percent' => 'required|numeric|min:0|max:100',
            
            // Standing instructions validation
            'standing_instructions.si_number' => 'nullable|string|max:255',
            'standing_instructions.si_client_bank_id' => 'nullable|exists:client_banks,id',
            'standing_instructions.si_company_bank_id' => 'nullable|exists:company_bank_details,id',
            'standing_instructions.si_start_date' => 'nullable|date',
            'standing_instructions.si_amount' => 'nullable|numeric|min:0',
            'standing_instructions.si_no_of_payments' => 'nullable|integer|min:1',
            'standing_instructions.attachment_si_image_url' => 'nullable|string',
            'standing_instructions.attachment_notes_image_url' => 'nullable|string',
        ];
    }
}
