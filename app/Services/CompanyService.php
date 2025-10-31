<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function create(array $data): Company
    {
        $data = $this->handleFileUploads($data);
        return Company::create($data);
    }

    public function update(Company $company, array $data): Company
    {
        $data = $this->handleFileUploads($data, $company);
        $company->update($data);
        return $company;
    }

    public function delete(Company $company): bool
    {
        $this->deleteFiles($company);
        return $company->delete();
    }

    private function handleFileUploads(array $data, ?Company $company = null): array
    {
        $fileFields = [
            'logo', 'attachment_pan', 'attachment_tan', 'attachment_gstin',
            'attachment_ckyc', 'attachment_partnership_deed', 'attachment_udyam_aadhar',
            'attachment_gumasta', 'attachment_msme'
        ];

        foreach ($fileFields as $field) {
            if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                if ($company && $company->$field) {
                    Storage::disk('public')->delete($company->$field);
                }
                $data[$field] = $data[$field]->store('companies', 'public');
            }
        }

        return $data;
    }

    private function deleteFiles(Company $company): void
    {
        $fileFields = [
            'logo', 'attachment_pan', 'attachment_tan', 'attachment_gstin',
            'attachment_ckyc', 'attachment_partnership_deed', 'attachment_udyam_aadhar',
            'attachment_gumasta', 'attachment_msme'
        ];

        foreach ($fileFields as $field) {
            if ($company->$field) {
                Storage::disk('public')->delete($company->$field);
            }
        }
    }
}