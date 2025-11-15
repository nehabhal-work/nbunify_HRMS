<?php

namespace App\Services;

use App\Models\CompanyBankDetail;
use Illuminate\Support\Facades\Validator;

class CompanyBankDetailService
{
    public function getByCompanyId($companyId)
    {
        return CompanyBankDetail::where('company_id', $companyId)->get();
    }

    public function getById($id)
    {
        return CompanyBankDetail::findOrFail($id);
    }

    public function create(int $companyId, array $data)
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

        return CompanyBankDetail::create([
            'company_id' => $companyId,
            'account_number' => $data['account_number'],
            'ifsc_code' => $data['ifsc_code'],
            'bank_name' => $data['bank_name'],
            'branch_name' => $data['branch_name'],
            'bank_code' => $data['bank_code'],
            'is_primary' => $data['is_primary'] ?? 0,
            'account_type' => $data['account_type'] ?? null,
        ]);
    }

    public function delete($id)
    {
        CompanyBankDetail::findOrFail($id)->delete();
    }

    public function deleteByCompanyId($companyId)
    {
        CompanyBankDetail::where('company_id', $companyId)->delete();
    }
}
