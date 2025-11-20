<?php

namespace App\Services;

use App\Models\ClientBank;
use Illuminate\Support\Facades\Validator;

class ClientBankService
{
    public function getByClientId($clientId)
    {
        return ClientBank::where('client_id', $clientId)->get();
    }

    public function getById($id)
    {
        return ClientBank::findOrFail($id);
    }

    public function create(array $data)
    {
        if($data['account_number'] == null) {
            return null;
        }

        Validator::validate($data, [
            'account_number' => 'required|numeric|max_digits:15',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string',
            'branch_name' => 'required|string',
            'bank_code' => 'required|string|max:4',
            'is_primary' => 'nullable|integer',
            'account_type' => 'nullable|in:savings,current,od_cc,nre,nri,nro,tem_deposit,ra',
        ]);

        return ClientBank::create([
            'client_id' => $data['client_id'],
            'account_number' => $data['account_number'],
            'ifsc_code' => $data['ifsc_code'],
            'bank_name' => $data['bank_name'],
            'branch_name' => $data['branch_name'],
            'bank_code' => $data['bank_code'],
            'is_primary' => $data['is_primary'] ?? 0,
            'account_type' => $data['account_type'] ?? null,
        ]);
    }

    public function update($clientBank, array $data)
    {
        Validator::validate($data, [
            'account_number' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string',
            'branch_name' => 'required|string',
            'bank_code' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'account_type' => 'nullable|in:savings,current,od_cc,nre,nri,nro,tem_deposit,ra',
        ]);

        return $clientBank->update([
            'account_number' => $data['account_number'],
            'ifsc_code' => $data['ifsc_code'],
            'bank_name' => $data['bank_name'],
            'branch_name' => $data['branch_name'],
            'bank_code' => $data['bank_code'] ?? null,
            'is_primary' => $data['is_primary'] ?? 0,
            'account_type' => $data['account_type'] ?? null,
        ]);
    }

    public function delete($id)
    {
        ClientBank::findOrFail($id)->delete();
    }

    public function deleteByClientId($clientId)
    {
        ClientBank::where('client_id', $clientId)->delete();
    }
}