<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'email' => 'required|nullable|email',
            'aadhar' => 'required|nullable|string|size:12',
            'pan' => 'required|nullable|string|size:10',

            // Address fields
            'res_address' => 'nullable|string',
            'res_country_code' => 'nullable|string|max:3',
            'res_state_code' => 'nullable|string|max:3',
            'res_city_code' => 'nullable|string|max:10',
            'res_pincode' => 'nullable|string|size:6',

            // Work information
            'branch_id' => 'nullable|exists:branches,id',
            'deptment_id' => 'nullable|exists:departments,id',
            'designation_id' => 'nullable|exists:designations,id',
            'joining_date' => 'nullable|date',
            'probation_date' => 'nullable|integer|min:0',
            'notice_date' => 'nullable|integer|min:0',
            'status' => 'required|in:contract,permanent,probation,intern',
            'reporting_manager' => 'nullable|exists:employees,id',
            'role' => 'nullable|string',

            // Salary information
            'basic_salary' => 'nullable|numeric|min:0',
            'hra' => 'nullable|numeric|min:0',
            'travel_allowance' => 'nullable|numeric|min:0',
            'conveyance_allowance' => 'nullable|numeric|min:0',
            'medical_allowance' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'other_allowances' => 'nullable|numeric|min:0',
            'prev_salary' => 'nullable|numeric|min:0',

            // File attachments
            'attachement_employee_photo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'attachement_aadhar' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'attachment_release_letter' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'attachment_expereance' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
            'attachment_pan' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'attachment_cv' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',

            // Bank details
            'banks' => 'nullable|array',
            'banks.*.ifsc_code' => 'required_with:banks|string|size:11',
            'banks.*.account_number' => 'required_with:banks|string|max:20',
            'banks.*.bank_name' => 'required_with:banks|string',
            'banks.*.branch_name' => 'required_with:banks|string',
            'banks.*.bank_code' => 'nullable|string|max:4',
            'banks.*.account_type' => 'nullable|in:savings,current,od_cc,nre,nri,nro,tem_deposit,ra',
            'banks.*.is_primary' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Employee name is required.',
            'email.unique' => 'This email is already registered.',
            'aadhar.size' => 'Aadhar number must be exactly 12 digits.',
            'pan.size' => 'PAN number must be exactly 10 characters.',
            'res_pincode.size' => 'Pincode must be exactly 6 digits.',
            'banks.*.ifsc_code.required_with' => 'IFSC code is required when bank details are provided.',
            'banks.*.ifsc_code.size' => 'IFSC code must be exactly 11 characters.',
            'banks.*.account_number.required_with' => 'Account number is required when bank details are provided.',
        ];
    }
}
