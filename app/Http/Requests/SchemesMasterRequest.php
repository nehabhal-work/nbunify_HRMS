<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchemesMasterRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_date'     => ['required', 'date'],
            'end_date'       => ['required', 'date', 'after_or_equal:start_date'],

            'scheme_name'    => ['required', 'string', 'max:100'],

            'roi_min'        => ['required', 'numeric', 'min:0'],
            'roi_max'        => ['required', 'numeric', 'min:0', 'gte:roi_min'],
            'roi_min_additional' => ['nullable', 'numeric', 'min:0'],
            'roi_max_additional' => ['nullable', 'numeric', 'min:0'],

            'tenure_type'    => ['required', 'in:days,months,years'],
            'tenure_min'     => ['required', 'integer', 'min:1'],
            'tenure_max'     => ['required', 'integer', 'gte:tenure_min'],

            // ⭐ MULTIPLE FREQUENCIES
            'frequency'      => ['required', 'array'],
            'frequency.*'    => ['in:monthly,quarterly,half-yearly,yearly,compounding'],
        ];
    }
    public function messages(): array
    {
        return [
            'end_date.after_or_equal' => 'The end date must be a date after or equal to start date.',
            'roi_max.gte'             => 'The maximum ROI must be greater than or equal to minimum ROI.',
            'tenure_max.gte'          => 'The maximum tenure must be greater than or equal to minimum tenure.',
            'frequency.required'      => 'Please select at least one payout frequency.',
            'frequency.array'         => 'Invalid format for frequency selection.',
            'frequency.*.in'          => 'Selected frequency is invalid.',
        ];
    }
}
