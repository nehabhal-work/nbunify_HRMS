<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date|before:today',
            'live_status' => 'nullable|in:alive,deceased',
            'dod' => 'nullable|date|after:dob',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'nationality' => 'nullable|in:ri,nro,nre,pio,oci,gch,trioc,fn,other',
            'occupation' => 'nullable|in:private_sector,public_sector,government,business,eduation,professional,agriculture,student,doctor,housewife,retired,other',
            'pan_no' => 'nullable|string|max:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'aadhar_no' => 'nullable|string|max:12|regex:/^[0-9]{12}$/',
            'ckyc_no' => 'nullable|string|max:20',
            'mobile_no' => 'nullable|string|max:15',
            'whatsapp_no' => 'nullable|string|max:15',
            'landline_no' => 'nullable|string|max:15',
            'email' => 'nullable|email',
            'res_pincode' => 'nullable|string|max:6',
            'office_pincode' => 'nullable|string|max:6',
            'remarks' => 'nullable|string|max:100',
            'attachment_client_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'attachment_pan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'attachment_aadhar_front' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'attachment_aadhar_back' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'attachment_signature' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'attachment_ckyc' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'attachment_other_documents' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ];
    }
}
