<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'logo' => ['nullable', 'file', 'image', 'max:2048', 'mimes:jpeg,jpg,png,gif'],
            'name' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'in:sole_proprietorship,partnership,pvt_ltd,public_ltd,llp,huf,ngo'],
            'code' => ['nullable', 'string', 'max:255', Rule::unique('companies')->ignore($this->company)],
            'domain' => ['nullable', 'string', 'max:255'],
            'watermark_no' => ['nullable', 'string', 'max:255'],
            'copyrights_no' => ['nullable', 'string', 'max:255'],
            'cin_no' => ['nullable', 'string', 'regex:/^[LUF]\d{5}[A-Z]{2}\d{4}[A-Z]{3}\d{6}$/'],
            'pan_no' => ['nullable', 'string', 'regex:/^[A-Z]{5}\d{4}[A-Z]{1}$/'],
            'tan_no' => ['nullable', 'string', 'regex:/^[A-Z]{4}\d{5}[A-Z]{1}$/'],
            'gstin' => ['nullable', 'string', 'regex:/^\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}$/'],
            'udyam_aadhar_no' => ['nullable', 'string', 'regex:/^UDYAM-[A-Z]{2}-\d{2}-\d{7}$/'],
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
            'registered_pincode' => ['nullable', 'string', 'regex:/^\d{6}$/'],
            'corporate_address' => ['nullable', 'string'],
            'corporate_country' => ['nullable', 'string', 'max:255'],
            'corporate_state' => ['nullable', 'string', 'max:255'],
            'corporate_city' => ['nullable', 'string', 'max:255'],
            'corporate_pincode' => ['nullable', 'string', 'regex:/^\d{6}$/'],
            'additional_address' => ['nullable', 'string'],
            'additional_country' => ['nullable', 'string', 'max:255'],
            'additional_state' => ['nullable', 'string', 'max:255'],
            'additional_city' => ['nullable', 'string', 'max:255'],
            'additional_pincode' => ['nullable', 'string', 'regex:/^\d{6}$/'],
            'contact_person_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'attachment_pan' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpeg,jpg,png'],
            'attachment_tan' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpeg,jpg,png'],
            'attachment_gstin' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpeg,jpg,png'],
            'attachment_ckyc' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpeg,jpg,png'],
            'attachment_partnership_deed' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpeg,jpg,png'],
            'attachment_udyam_aadhar' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpeg,jpg,png'],
            'attachment_gumasta' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpeg,jpg,png'],
            'attachment_msme' => ['nullable', 'file', 'max:5120', 'mimes:pdf,jpeg,jpg,png'],
            'brand_name' => ['nullable','string','max:50'],
            'proprietor_name' => ['nullable','string','max:50'],
            'proprietor_phone' => ['nullable','string','max:20'],
            'proprietor_email' => ['nullable','string','max:20'],
            'proprietor_whatsapp' => ['nullable','string','max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required.',
            'company_type.required' => 'Company type is required.',
            'company_type.in' => 'Please select a valid company type.',

            'code.unique' => 'This company code is already taken.',
            'email.email' => 'Please provide a valid email address.',
            'est_date.date' => 'Please provide a valid establishment date.',
            'pan_no.regex' => 'PAN number must be in format: ABCDE1234F',
            'gstin.regex' => 'GSTIN must be in format: 22AAAAA0000A1Z5',
            'cin_no.regex' => 'CIN number must be in format: L12345AB1234ABC123456',
            'tan_no.regex' => 'TAN number must be in format: ABCD12345E',
            'udyam_aadhar_no.regex' => 'Udyam Aadhar must be in format: UDYAM-XX-00-0000000',
            'registered_pincode.regex' => 'Pincode must be 6 digits.',
            'corporate_pincode.regex' => 'Pincode must be 6 digits.',
            'additional_pincode.regex' => 'Pincode must be 6 digits.',
            
            'logo.file' => 'Logo must be a file.',
            'logo.image' => 'Logo must be an image.',
            'logo.max' => 'Logo must not exceed 2MB.',
            'logo.mimes' => 'Logo must be jpeg, jpg, png, or gif format.',
            
            '*.file' => 'The :attribute must be a file.',
            '*.max' => 'The :attribute must not exceed 5MB.',
            '*.mimes' => 'The :attribute must be pdf, jpeg, jpg, or png format.',
            
        ];
    }
}
