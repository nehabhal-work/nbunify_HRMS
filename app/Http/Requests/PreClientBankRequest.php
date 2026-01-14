<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreClientBankRequest extends FormRequest
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
            'account_number' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string|max:255',
            'branch_name' => 'required|string|max:255',
            'bank_code' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'account_type' => 'nullable|in:savings,current,od_cc,nre,nri,nro,tem_deposit,ra',
            'attachment_cancelled_cheque_url' => 'nullable|url',
            'operation_mode' => 'nullable|string|max:255',
            'holder_name_1' => 'nullable|string|max:255',
            'holder_name_2' => 'nullable|string|max:255',
            'holder_name_3' => 'nullable|string|max:255',
            'micrcode' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'preclient_id.required' => 'PreClient ID is required.',
            'preclient_id.exists' => 'Selected preclient does not exist.',
            'account_number.required' => 'Account number is required.',
            'ifsc_code.required' => 'IFSC code is required.',
            'bank_name.required' => 'Bank name is required.',
            'branch_name.required' => 'Branch name is required.',
        ];
    }
}
