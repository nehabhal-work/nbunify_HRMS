<?php

namespace App\Services;

use App\Models\CompanyBankDetail;
use Illuminate\Database\Eloquent\Collection;

class CompanyBankDetailService
{
    public function create(array $data): CompanyBankDetail
    {
        return CompanyBankDetail::create($data);
    }

    public function update(CompanyBankDetail $bankDetail, array $data): CompanyBankDetail
    {
        $bankDetail->update($data);
        return $bankDetail->fresh();
    }

    public function delete(CompanyBankDetail $bankDetail): bool
    {
        return $bankDetail->delete();
    }

    public function getByCompany(int $companyId): Collection
    {
        return CompanyBankDetail::where('company_id', $companyId)->get();
    }

    public function setPrimary(CompanyBankDetail $bankDetail): CompanyBankDetail
    {
        // Set all other bank details for this company as non-primary
        CompanyBankDetail::where('company_id', $bankDetail->company_id)
            ->where('id', '!=', $bankDetail->id)
            ->update(['is_primary' => false]);

        // Set this one as primary
        $bankDetail->update(['is_primary' => true]);
        
        return $bankDetail->fresh();
    }
}