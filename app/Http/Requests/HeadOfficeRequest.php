<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $headOfficeId = $this->route('head_office')?->id;
        $companyId    = $this->input('company_id');

        return [
            'company_id'     => ['required', 'integer', 'exists:companies,id'],

            'name'           => ['required', 'string', 'max:255'],

            // code must be unique per company (composite unique)
            'code'           => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('head_offices')->where(fn($q) => $q->where('company_id', $companyId))
                    ->ignore($headOfficeId),
            ],

            'email'          => ['required', 'email', 'max:255'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'fax'            => ['nullable', 'string', 'max:20'],

            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:100'],
            'state'          => ['required', 'string', 'max:100'],
            'country'        => ['required', 'string', 'max:100'],
            'pincode'        => ['nullable', 'string', 'max:20'],

            'timezone'       => ['nullable', 'string', 'max:60', 'timezone'],
            'currency'       => ['nullable', 'string', 'max:10', 'size:3'],   // ISO 4217 e.g. INR, USD

            'manager_name'   => ['nullable', 'string', 'max:255'],
            'manager_email'  => ['nullable', 'email', 'max:255'],

            'established_at' => ['nullable', 'date', 'before_or_equal:today'],
            'is_active'      => ['nullable', 'boolean'],

            'meta'           => ['nullable', 'array'],
            'meta.*'         => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.alpha_dash'              => 'Code may only contain letters, numbers, dashes, and underscores.',
            'code.unique'                  => 'This code is already used for another head office under the same company.',
            'currency.size'                => 'Currency must be a 3-letter ISO 4217 code (e.g. INR, USD, EUR).',
            'timezone.timezone'            => 'Please provide a valid timezone (e.g. Asia/Kolkata, UTC).',
            'established_at.before_or_equal' => 'Established date cannot be in the future.',
            'company_id.exists'            => 'The selected company does not exist.',
        ];
    }

    public function attributes(): array
    {
        return [
            'company_id'     => 'Company',
            'name'           => 'Office Name',
            'code'           => 'Office Code',
            'email'          => 'Email Address',
            'phone'          => 'Phone Number',
            'fax'            => 'Fax Number',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'city'           => 'City',
            'state'          => 'State',
            'country'        => 'Country',
            'pincode'        => 'Pincode',
            'timezone'       => 'Timezone',
            'currency'       => 'Currency',
            'manager_name'   => 'Manager Name',
            'manager_email'  => 'Manager Email',
            'established_at' => 'Established Date',
            'is_active'      => 'Status',
            'meta'           => 'Meta Data',
        ];
    }
}
