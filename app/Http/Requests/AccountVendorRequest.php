<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccountVendorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /* Client / Vendor Type */
            'opt_client_vendor' => [Rule::in(['client', 'vendor', 'both'])],

            /* Entity */
            'entity_type' => ['required', Rule::in(['individual', 'non_individual'])],
            'non_individual_type' => ['nullable', 'string', 'max:100'],

            /* Tax */
            'gst_mode' => ['required', Rule::in(['GST', 'Non-GST'])],
            'gst_no' => ['nullable', 'string', 'size:15', 'required_if:gst_mode,GST'],
            'pan' => ['nullable', 'string', 'size:10'],
            'tan_no' => ['nullable', 'string', 'size:10'],
            'vat_no' => ['nullable', 'string', 'max:12'],
            'cin' => ['nullable', 'string', 'max:25'],
            'aadhar_no' => ['nullable', 'string', 'max:15'],

            /* Client Classification */
            'client_type' => ['nullable', Rule::in(['retainer', 'non-retainer'])],
            'under_head' => ['nullable', 'string', 'max:100'],

            /* Financial */
            'service_charges' => ['nullable', 'numeric', 'min:0'],

            /* Primary Details */
            'client_name' => ['required', 'string', 'max:100'],
            'vendor_mobile' => ['nullable', 'digits:10'],
            'vendor_email' => ['nullable', 'email', 'max:100'],

            /* Contact Person */
            'contact_person_name' => ['required', 'string', 'max:100'],
            'contact_email' => ['nullable', 'email', 'max:100'],
            'contact_mobile' => ['nullable', 'digits:10'],

            /* Address */
            'res_address' => ['nullable', 'string'],
            'res_country' => ['nullable', 'string', 'max:100'],
            'res_country_code' => ['nullable', 'string', 'max:10'],
            'res_state' => ['nullable', 'string', 'max:100'],
            'res_state_code' => ['nullable', 'string', 'max:10'],
            'res_city' => ['nullable', 'string', 'max:100'],
            'res_city_code' => ['nullable', 'string', 'max:10'],
            'res_pincode' => ['nullable', 'digits:6'],
            'remarks' => ['nullable', 'string', 'max:255'],

            /* Bank Details */
            'ifsc_code' => ['string', 'size:11'],
            'account_number' => ['string', 'max:20'],
            'bank_name' => ['string', 'max:100'],
            'branch_name' => ['string', 'max:100'],
            'bank_code' => ['nullable', 'string', 'max:20'],

            /* File Attachments */
            'attachement_user_photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
            'attachment_pan' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'attachement_aadhar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'attachment_gst' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'attachment_other_documents' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:4096'],
            'attachment_cancelled_cheque' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }
}
