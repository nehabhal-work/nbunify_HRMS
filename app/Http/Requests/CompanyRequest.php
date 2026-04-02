<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('company')?->id;

        return [
            // Basic Info
            'name'          => ['required', 'string', 'max:255'],
            'legal_name'    => ['nullable', 'string', 'max:255'],
            'company_type'  => ['required', Rule::in(array_keys(Company::COMPANY_TYPES))],
            'website'       => ['nullable', 'string', 'max:255'],
            'logo'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'email'          => ['nullable', 'email', 'max:255'],
            'mobile'          => ['nullable', 'string', 'max:15'],
            'is_active'      => ['nullable', 'string'],

            // Registration Numbers
            'watermark_no'               => ['nullable', 'string', 'max:100'],
            'copyrights_no'              => ['nullable', 'string', 'max:100'],
            'cin_no'                     => ['nullable', 'string', 'max:21', Rule::unique('companies', 'cin_no')->ignore($companyId)],
            'pan_no'                     => ['nullable', 'string', 'max:10', 'regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/', Rule::unique('companies', 'pan_no')->ignore($companyId)],
            'tan_no'                     => ['nullable', 'string', 'max:10', Rule::unique('companies', 'tan_no')->ignore($companyId)],
            'gstin'                      => ['nullable', 'string', 'max:15', 'regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/', Rule::unique('companies', 'gstin')->ignore($companyId)],
            'udyam_aadhar_no'            => ['nullable', 'string', 'max:19', Rule::unique('companies', 'udyam_aadhar_no')->ignore($companyId)],
            'partnership_registration_no' => ['nullable', 'string', 'max:100'],
            'roc_no'                     => ['nullable', 'string', 'max:100'],
            'msme_certification_no'      => ['nullable', 'string', 'max:100', Rule::unique('companies', 'msme_certification_no')->ignore($companyId)],
            'ckyc'                       => ['nullable', 'string', 'max:14', Rule::unique('companies', 'ckyc')->ignore($companyId)],
            'gumasta_no'                 => ['nullable', 'string', 'max:100'],

            // Establishment Date
            'est_date' => ['nullable', 'date', 'before_or_equal:today'],

            // Attachments
            'attachment_pan'              => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'attachment_tan'              => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'attachment_gstin'            => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'attachment_ckyc'             => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'attachment_partnership_deed' => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'attachment_udyam_aadhar'     => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'attachment_gumasta'          => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
            'attachment_msme'             => ['nullable', 'file', 'mimes:pdf,jpeg,png,jpg', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'pan_no.regex'   => 'PAN number format is invalid. Expected format: ABCDE1234F',
            'gstin.regex'    => 'GSTIN format is invalid. Expected 15-character GST number.',
            'est_date.before_or_equal' => 'Establishment date cannot be in the future.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'                        => 'Company Name',
            'legal_name'                  => 'Legal Name',
            'company_type'                => 'Company Type',
            'website'                     => 'Website',
            'logo'                        => 'Logo',
            'email'                        => 'Email',
            'mobile'                       => 'Mobile',
            'watermark_no'                => 'Watermark Number',
            'copyrights_no'               => 'Copyrights Number',
            'cin_no'                      => 'CIN Number',
            'pan_no'                      => 'PAN Number',
            'tan_no'                      => 'TAN Number',
            'gstin'                       => 'GSTIN',
            'udyam_aadhar_no'             => 'Udyam Aadhar Number',
            'partnership_registration_no' => 'Partnership Registration Number',
            'roc_no'                      => 'ROC Number',
            'msme_certification_no'       => 'MSME Certification Number',
            'ckyc'                        => 'CKYC Number',
            'gumasta_no'                  => 'Gumasta Number',
            'est_date'                    => 'Establishment Date',
            'attachment_pan'              => 'PAN Attachment',
            'attachment_tan'              => 'TAN Attachment',
            'attachment_gstin'            => 'GSTIN Attachment',
            'attachment_ckyc'             => 'CKYC Attachment',
            'attachment_partnership_deed' => 'Partnership Deed',
            'attachment_udyam_aadhar'     => 'Udyam Aadhar Attachment',
            'attachment_gumasta'          => 'Gumasta Attachment',
            'attachment_msme'             => 'MSME Attachment',
        ];
    }
}
