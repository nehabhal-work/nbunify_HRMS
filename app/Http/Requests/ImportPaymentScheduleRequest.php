<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportPaymentScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'investment_id' => 'required|exists:investments,id',
            'excel_file' => 'required|file|mimes:xlsx,xls|max:2048',
        ];
    }
}
