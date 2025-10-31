<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'in:sole_proprietorship,partnership,pvt_ltd,public_ltd,llp,huf,ngo'],
            'code' => ['required', 'string', 'max:255', Rule::unique('companies')->ignore($this->company)],
            'domain' => ['nullable', 'string', 'max:255'],
            'watermark_no' => ['nullable', 'string', 'max:255'],
            'copyrights_no' => ['nullable', 'string', 'max:255'],
            'cin_no' => ['nullable', 'string', 'max:255'],
            'pan_no' => ['nullable', 'string', 'max:255'],
            'tan_no' => ['nullable', 'string', 'max:255'],
            'gstin' => ['nullable', 'string', 'max:255'],
            'udyam_aadhar_no' => ['nullable', 'string', 'max:255'],
            'partnership_registration_no' => ['nullable', 'string', 'max:255'],
            'roc_no' => ['nullable', 'string', 'max:255'],
            'msme_certification_no' => ['nullable', 'string', 'max:255'],
            'ckyc' => ['nullable', 'string', 'max:255'],
            'gumasta_no' => ['nullable', 'string', 'max:255'],
            'est_date' => ['nullable', 'date'],
            'registered_address' => ['nullable', 'string'],
            'registered_country' => ['nullable', 'string', 'max:255'],
            'registered_state' => ['nullable', 'string', 'max:255'],
            'registered_city' => ['nullable', 'string', 'max:255'],
            'registered_pincode' => ['nullable', 'string', 'max:10'],
            'corporate_address' => ['nullable', 'string'],
            'corporate_country' => ['nullable', 'string', 'max:255'],
            'corporate_state' => ['nullable', 'string', 'max:255'],
            'corporate_city' => ['nullable', 'string', 'max:255'],
            'corporate_pincode' => ['nullable', 'string', 'max:10'],
            'additional_address' => ['nullable', 'string'],
            'additional_country' => ['nullable', 'string', 'max:255'],
            'additional_state' => ['nullable', 'string', 'max:255'],
            'additional_city' => ['nullable', 'string', 'max:255'],
            'additional_pincode' => ['nullable', 'string', 'max:10'],
            'contact_person_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'attachment_pan' => ['nullable', 'string', 'max:255'],
            'attachment_tan' => ['nullable', 'string', 'max:255'],
            'attachment_gstin' => ['nullable', 'string', 'max:255'],
            'attachment_ckyc' => ['nullable', 'string', 'max:255'],
            'attachment_partnership_deed' => ['nullable', 'string', 'max:255'],
            'attachment_udyam_aadhar' => ['nullable', 'string', 'max:255'],
            'attachment_gumasta' => ['nullable', 'string', 'max:255'],
            'attachment_msme' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required.',
            'company_type.required' => 'Company type is required.',
            'company_type.in' => 'Please select a valid company type.',
            'code.required' => 'Company code is required.',
            'code.unique' => 'This company code is already taken.',
            'email.email' => 'Please provide a valid email address.',
            'est_date.date' => 'Please provide a valid establishment date.',
        ];
    }
}