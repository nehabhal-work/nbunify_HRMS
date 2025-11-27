<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientBankRequest extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'ifsc_code' => 'required|string|max:11',
            'account_number' => 'required|string|max:20',
            'bank_name' => 'nullable|string|max:255',
            'branch_name' => 'nullable|string|max:255',
            'bank_code' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'account_type' => 'nullable|in:savings,current,od_cc,nre,nri,nro,tem_deposit,ra',
            'attachment_cancelled_cheque_url' => 'nullable|string|url',
            'operation_mode' => 'nullable|string|max:255',
            'holder_name_1' => 'nullable|string|max:255',
            'holder_name_2' => 'nullable|string|max:255',
            'holder_name_3' => 'nullable|string|max:255',
            'micrcode' => 'nullable|string|max:9',
        ];
    }
}
