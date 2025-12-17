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
            'client_id' => 'required|exists:clients,id',
            'other_holders' => 'nullable|array',
            // 'other_holders.*' => 'exists:clients,id',
            'scheme_id' => 'required|exists:schemes_master,id',
            'investment_amount' => 'required|numeric|min:0',
            'tenure_type' => 'required|string|max:255',
            'tenure_count' => 'required|integer|min:1',
            'frequency' => 'required|string|max:255', // Payout frequency
            'roi_percent' => 'required|numeric|min:0|max:100',
            'additional_roi_percent' => 'nullable|numeric|min:0|max:100',
            'maturity_date' => 'nullable|date|after:investment_date',
            'payout_amount' => 'nullable|numeric|min:0',
            'has_tds' => 'boolean',
            'client_bank_id' => 'required',
            'company_bank_id' => 'required'
        ];
    }
}
