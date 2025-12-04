<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;


class ClientRequest extends FormRequest
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
           
            'name' => 'required|string|max:50',
            'gender' => 'required|in:male,female,other',
            'dob' => 'required|date|before:today',
            'live_status' => 'nullable|in:alive,deceased',
            'dod' => 'nullable|date|after:dob',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'nationality' => 'nullable|in:ri,nro,nre,pio,oci,gch,trioc,fn,other',
            'occupation' => 'nullable|in:private_sector,public_sector,government,business,eduation,professional,agriculture,student,doctor,housewife,retired,other',
            'pan_no' => 'required|string|max:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'aadhar_no' => 'required|string|max:12|regex:/^[0-9]{12}$/',
            'ckyc_no' => 'nullable|string|max:20',
            'mobile_no' => 'required|string|max:15',
            'whatsapp_no' => 'nullable|string|max:15',
            'landline_no' => 'nullable|string|max:15',
            // 'email' => 'required|email',
            'email' => 'required|email:rfc,dns',
            'res_address' => 'nullable|string|max:255',
            'res_country' => 'nullable|string|max:255',
            'res_country_code' => 'nullable|string|max:255',
            'res_state' => 'nullable|string|max:255',
            'res_state_code' => 'nullable|string|max:255',
            'res_city' => 'nullable|string|max:255',
            'res_city_code' => 'nullable|string|max:255',
            'res_pincode' => 'nullable|string|max:255',
            'office_address' => 'nullable|string|max:255',
            'office_country' => 'nullable|string|max:255',
            'office_country_code' => 'nullable|string|max:255',
            'office_state' => 'nullable|string|max:255',
            'office_state_code' => 'nullable|string|max:255',
            'office_city' => 'nullable|string|max:255',
            'office_city_code' => 'nullable|string|max:255',
            'office_pincode' => 'nullable|string|max:6',
            'relation_manager_id' => 'nullable',
            'remarks' => 'nullable|string|max:100',
            'attachment_client_photo_url' => ['nullable', 'url'],
            'attachment_pan_url' => ['nullable', 'url'],
            'attachment_aadhar_front_url' => ['nullable', 'url'],
            'attachment_aadhar_back_url' => ['nullable', 'url'],
            'attachment_signature_url' => ['nullable', 'url'],
            'attachment_ckyc_url' => ['nullable', 'url'],
            'attachment_other_documents_url' => ['nullable', 'url'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Client name is required.',
            'dob.required' => 'Date of birth is required.',
            'dob.before' => 'Date of birth must be before today.',
            'pan_no.required' => 'PAN number is required.',
            'pan_no.regex' => 'PAN number must be in format: ABCDE1234F',
            'aadhar_no.required' => 'Aadhar number is required.',
            'aadhar_no.regex' => 'Aadhar number must be 12 digits.',
            'mobile_no.required' => 'Mobile number is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',

            '*.url' => 'The :attribute must be a valid URL.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Log::info('Validation failed for ClientRequest', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all()
        ]);

        parent::failedValidation($validator);
    }
}
