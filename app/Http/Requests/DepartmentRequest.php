<?php

namespace App\Http\Requests;

use App\Models\Department;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $deptId    = $this->route('department')?->id;
        $companyId = $this->input('company_id');

        return [
            'company_id'     => ['required', 'integer', 'exists:companies,id'],

            // branch and head_office are optional but must belong to the company if provided
            'branch_id'      => [
                'nullable',
                'integer',
                Rule::exists('branches', 'id')->where('company_id', $companyId),
            ],
            'head_office_id' => [
                'nullable',
                'integer',
                Rule::exists('head_offices', 'id')->where('company_id', $companyId),
            ],

            // parent must belong to same company; cannot be self
            'parent_id'      => [
                'nullable',
                'integer',
                Rule::exists('departments', 'id')->where('company_id', $companyId),
                function ($attribute, $value, $fail) use ($deptId) {
                    if ($deptId && $value == $deptId) {
                        $fail('A department cannot be its own parent.');
                    }
                    if ($deptId && $value) {
                        $dept = Department::find($deptId);
                        if ($dept && $dept->wouldCreateCycle((int) $value)) {
                            $fail('Assigning this parent would create a circular reference.');
                        }
                    }
                },
            ],

            'name'        => ['required', 'string', 'max:255'],

            // code unique per company
            'code'        => [
                'required',
                'string',
                'max:50',
                'alpha_dash',
                Rule::unique('departments')
                    ->where(fn($q) => $q->where('company_id', $companyId))
                    ->ignore($deptId),
            ],

            'description' => ['nullable', 'string', 'max:1000'],
            'dept_type'   => ['required', Rule::in(array_keys(Department::DEPT_TYPES))],
            'email'       => ['nullable', 'email', 'max:255'],
            'phone_ext'   => ['nullable', 'string', 'max:20'],
            'head_name'   => ['nullable', 'string', 'max:255'],
            'head_email'  => ['nullable', 'email', 'max:255'],

            'budget'       => ['nullable', 'numeric', 'min:0', 'max:9999999999999.99'],
            'cost_centre'  => ['nullable', 'string', 'max:50'],

            'employee_count' => ['nullable', 'integer', 'min:0'],
            'is_active'      => ['nullable', 'boolean'],
            'sort_order'     => ['nullable', 'integer', 'min:0'],

            'meta'   => ['nullable', 'array'],
            'meta.*' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.alpha_dash'        => 'Code may only contain letters, numbers, dashes, and underscores.',
            'code.unique'            => 'This code is already used by another department in the same company.',
            'branch_id.exists'       => 'The selected branch does not belong to the chosen company.',
            'head_office_id.exists'  => 'The selected head office does not belong to the chosen company.',
            'parent_id.exists'       => 'The selected parent department does not exist in the same company.',
            'budget.max'             => 'Budget value exceeds the maximum allowed amount.',
        ];
    }

    public function attributes(): array
    {
        return [
            'company_id'     => 'Company',
            'branch_id'      => 'Branch',
            'head_office_id' => 'Head Office',
            'parent_id'      => 'Parent Department',
            'name'           => 'Department Name',
            'code'           => 'Department Code',
            'description'    => 'Description',
            'dept_type'      => 'Department Type',
            'email'          => 'Email Address',
            'phone_ext'      => 'Phone Extension',
            'head_name'      => 'Department Head Name',
            'head_email'     => 'Department Head Email',
            'budget'         => 'Budget',
            'cost_centre'    => 'Cost Centre',
            'employee_count' => 'Employee Count',
            'is_active'      => 'Status',
            'sort_order'     => 'Sort Order',
            'meta'           => 'Meta Data',
        ];
    }
}
