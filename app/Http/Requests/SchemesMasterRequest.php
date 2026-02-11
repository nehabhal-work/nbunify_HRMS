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
            'scheme_code'    => ['nullable', 'string', 'max:50'],
            'start_date'     => ['required', 'date'],
            'end_date'       => ['required', 'date', 'after_or_equal:start_date'],

            'scheme_name'    => ['required', 'string', 'max:100'],
            'name_type'      => ['required', 'string', 'in:' . implode(',', array_keys(config('scheme.name_types')))],

            'investment_type' => ['required', 'in:single,joined'],
            'min_investment'  => ['nullable', 'numeric', 'min:0'],
            'max_investment'  => ['nullable', 'numeric', 'min:0', 'gte:min_investment'],
            'investment_denomination' => ['nullable', 'numeric', 'min:0'],

            'roi_min'        => ['required', 'numeric', 'min:0'],
            'roi_max'        => ['required', 'numeric', 'min:0', 'gte:roi_min'],
            'roi_min_additional' => ['nullable', 'numeric', 'min:0'],
            'roi_max_additional' => ['nullable', 'numeric', 'min:0'],

            'tenure_type'    => ['required', 'in:days,months,years'],
            'tenure_min'     => ['required', 'integer', 'min:1'],
            'tenure_max'     => ['required', 'integer', 'gte:tenure_min'],

            'frequency'      => ['required', 'array'],
            'frequency.*'    => ['in:monthly,quarterly,half-yearly,yearly,compounding'],

            'exit_load_percent' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'lock_in_period'    => ['nullable', 'integer', 'min:0'],
            'lock_in_period_type' => ['nullable', 'in:days,months,years'],
        ];
    }
    public function messages(): array
    {
        return [
            'end_date.after_or_equal' => 'The end date must be a date after or equal to start date.',
            'roi_max.gte'             => 'The maximum ROI must be greater than or equal to minimum ROI.',
            'max_investment.gte'      => 'The maximum investment must be greater than or equal to minimum investment.',
            'tenure_max.gte'          => 'The maximum tenure must be greater than or equal to minimum tenure.',
            'frequency.required'      => 'Please select at least one payout frequency.',
            'frequency.array'         => 'Invalid format for frequency selection.',
            'frequency.*.in'          => 'Selected frequency is invalid.',
        ];
    }
}
