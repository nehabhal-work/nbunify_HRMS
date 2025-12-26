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
            'attachment_tds' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'attachment_tds_url' => 'nullable|string',
            'from_company_bank_id' => 'required|exists:company_bank_details,id',
            'to_client_bank_id' => 'required|exists:client_banks,id',

            // Input banks validation (arrays from form)
            'instrument' => 'nullable|array',
            'instrument.*' => 'required|string|max:255',
            'instrument_date' => 'nullable|array',
            'instrument_date.*' => 'required|date',
            'reference_no' => 'nullable|array',
            'reference_no.*' => 'nullable|string|max:255',
            'instrument_amt' => 'nullable|array',
            'instrument_amt.*' => 'required|numeric|min:0',
            'client_output_bank' => 'nullable|array',
            'client_output_bank.*' => 'required|exists:client_banks,id',
            'instrumentImage' => 'nullable|array',
            'instrumentImage.*' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'company_bank_id' => 'nullable|array',
            'company_bank_id.*' => 'required|exists:company_bank_details,id',
            'effective_date' => 'nullable|array',
            'effective_date.*' => 'required|date',
            'company_reference_no' => 'nullable|array',
            'company_reference_no.*' => 'nullable|string|max:255',

            // Nominees validation (arrays from form)
            'client_family_id' => 'nullable|array',
            'client_family_id.*' => 'required|exists:client_families,id',
            'guardian_client_family_id' => 'nullable|array',
            'guardian_client_family_id.*' => 'nullable|exists:client_families,id',
            'percent' => 'nullable|array',
            'percent.*' => 'required|numeric|min:0|max:100',

            // Standing instructions validation
            'standing_instructions.si_number' => 'nullable|string|max:255',
            'standing_instructions.si_client_bank_id' => 'nullable|exists:client_banks,id',
            'standing_instructions.si_company_bank_id' => 'nullable|exists:company_bank_details,id',
            'standing_instructions.si_start_date' => 'nullable|date',
            'standing_instructions.si_amount' => 'nullable|numeric|min:0',
            'standing_instructions.si_no_of_payments' => 'nullable|integer|min:1',
            'standing_instructions.attachment_si_image_url' => 'nullable|string',
            'standing_instructions.attachment_notes_image_url' => 'nullable|string',

            // Maker checker fields
            'status' => 'nullable|string|in:open,closed',
            'action_status' => 'nullable|string|in:new,renewed,matured,merged,claimed,withdraw',
            'exit_load_percent' => 'nullable|numeric|min:0|max:100',
            'lock_in_period' => 'nullable|integer|min:0',
            'lock_in_period_type' => 'nullable|string|in:days,months,years',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validate investment amount equals sum of instrument amounts
            if ($this->has('investment_amount') && $this->has('instrument_amt')) {
                $investmentAmount = (float) $this->input('investment_amount');
                $instrumentAmounts = array_map('floatval', $this->input('instrument_amt', []));
                $totalInstrumentAmount = array_sum($instrumentAmounts);

                if ($investmentAmount != $totalInstrumentAmount) {
                    $validator->errors()->add('investment_amount',
                        'Investment amount must equal the sum of all instrument amounts. ' .
                        'Investment: ' . number_format($investmentAmount, 2) .
                        ', Instruments total: ' . number_format($totalInstrumentAmount, 2)
                    );
                }
            }

            // Validate percent array sums to 100%
            if ($this->has('percent')) {
                $percentages = array_map('floatval', $this->input('percent', []));
                $totalPercentage = array_sum($percentages);

                if ($totalPercentage != 100) {
                    $validator->errors()->add('percent',
                        'Total percentage must equal 100%. Current total: ' . number_format($totalPercentage, 2) . '%'
                    );
                }
            }
        });
    }
}
