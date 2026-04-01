<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BranchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $branchId  = $this->route('branch')?->id;
        $companyId = $this->input('company_id');

        return [
            'company_id'     => ['required', 'integer', 'exists:companies,id'],
            'head_office_id' => [
                'required',
                'integer',
                // Ensure the head office belongs to the given company
                Rule::exists('head_offices', 'id')->where('company_id', $companyId),
            ],

            'name'        => ['required', 'string', 'max:255'],

            // code unique per company (mirrors DB composite unique index)
            'code'        => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('branches')
                    ->where(fn($q) => $q->where('company_id', $companyId))
                    ->ignore($branchId),
            ],

            'branch_type' => ['required', Rule::in(array_keys(Branch::BRANCH_TYPES))],
            'email'       => ['required', 'email', 'max:255'],
            'phone'       => ['nullable', 'string', 'max:20'],

            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:100'],
            'state'          => ['required', 'string', 'max:100'],
            'country'        => ['required', 'string', 'max:100'],
            'postal_code'    => ['nullable', 'string', 'max:20'],

            'manager_name'  => ['nullable', 'string', 'max:255'],
            'manager_email' => ['nullable', 'email', 'max:255'],

            // opening_hours: { "mon": { "open": "09:00", "close": "18:00" }, ... }
            'opening_hours'              => ['nullable', 'array'],
            'opening_hours.*.open'       => ['nullable', 'date_format:H:i'],
            'opening_hours.*.close'      => ['nullable', 'date_format:H:i', 'after:opening_hours.*.open'],
            'opening_hours.*.is_holiday' => ['nullable', 'boolean'],

            'employee_count' => ['nullable', 'integer', 'min:0'],
            'status'         => ['nullable', Rule::in(array_keys(Branch::STATUSES))],
            'sort_order'     => ['nullable', 'integer', 'min:0'],

            'meta'   => ['nullable', 'array'],
            'meta.*' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.alpha_dash'       => 'Code may only contain letters, numbers, dashes, and underscores.',
            'code.unique'           => 'This code is already used for another branch under the same company.',
            'head_office_id.exists' => 'The selected head office does not belong to the chosen company.',
            'opening_hours.*.close.after' => 'Closing time must be after opening time.',
        ];
    }

    public function attributes(): array
    {
        return [
            'company_id'     => 'Company',
            'head_office_id' => 'Head Office',
            'name'           => 'Branch Name',
            'code'           => 'Branch Code',
            'branch_type'    => 'Branch Type',
            'email'          => 'Email Address',
            'phone'          => 'Phone Number',
            'address_line_1' => 'Address Line 1',
            'address_line_2' => 'Address Line 2',
            'city'           => 'City',
            'state'          => 'State',
            'country'        => 'Country',
            'postal_code'    => 'Postal Code',
            'manager_name'   => 'Manager Name',
            'manager_email'  => 'Manager Email',
            'opening_hours'  => 'Opening Hours',
            'employee_count' => 'Employee Count',
            'status'         => 'Status',
            'sort_order'     => 'Sort Order',
            'meta'           => 'Meta Data',
        ];
    }
}
