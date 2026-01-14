<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreClientFamilyRequest extends FormRequest
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
            'preclient_id' => 'required|exists:preclients,id',
            'name' => 'required|string|max:50',
            'gender' => 'nullable|in:male,female,other',
            'dob' => 'nullable|date|before:today',
            'live_status' => 'nullable|in:alive,deceased',
            'dod' => 'nullable|date|after:dob',
            'marital_status' => 'nullable|in:single,married,divorced,widowed',
            'nationality' => 'nullable|in:ri,nro,nre,pio,oci,gch,trioc,fn,other',
            'occupation' => 'nullable|in:private_sector,public_sector,government,business,education,professional,agriculture,student,doctor,housewife,retired,other',
            'mobile_no' => 'nullable|string|max:15',
            'whatsapp_no' => 'nullable|string|max:15',
            'landline_no' => 'nullable|string|max:15',
            'email' => 'nullable|email',
            'pan_no' => 'nullable|string|max:10|regex:/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/',
            'aadhar_no' => 'nullable|string|max:12|regex:/^[0-9]{12}$/',
            'res_address' => 'nullable|string|max:255',
            'res_country' => 'nullable|string|max:255',
            'res_state' => 'nullable|string|max:255',
            'res_city' => 'nullable|string|max:255',
            'res_pincode' => 'nullable|string|max:6',
            'office_address' => 'nullable|string|max:255',
            'office_country' => 'nullable|string|max:255',
            'office_state' => 'nullable|string|max:255',
            'office_city' => 'nullable|string|max:255',
            'office_pincode' => 'nullable|string|max:6',
            'relation_id' => 'nullable|exists:family_relations,id',
            'remarks' => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'preclient_id.required' => 'PreClient ID is required.',
            'preclient_id.exists' => 'Selected preclient does not exist.',
            'name.required' => 'Family member name is required.',
            'pan_no.regex' => 'PAN number must be in format: ABCDE1234F',
            'aadhar_no.regex' => 'Aadhar number must be 12 digits.',
            'email.email' => 'Please provide a valid email address.',
        ];
    }
}
