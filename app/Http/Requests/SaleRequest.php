<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'financial_year' => 'required|string',
            'customer_id' => 'required|exists:customers,id',
            'invoice_no' => 'required|string|max:20',
            'bill_date' => 'required|date',
            'particular' => 'required|array',
            'particular.*' => 'required|string|max:100',
            'hsn' => 'array',
            'hsn.*' => 'nullable|string|max:15',
            'amount' => 'required|array',
            'amount.*' => 'required|numeric|min:0',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|min:0',
            'bill_amount' => 'required|array',
            'bill_amount.*' => 'required|numeric|min:0'
        ];
    }
}
