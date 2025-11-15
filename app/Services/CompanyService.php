<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function __construct(private FileStorageService $fileStorageService)
    {
    }

    public function getAll()
    {
        return Company::all();
    }

    public function getById($id)
    {
        return Company::findOrFail($id);
    }

    public function create(array $data): Company
    {
        $data = $this->prepareCompanyData($data);
        $company = Company::create($this->extractNonFileData($data));
        $fileData = $this->handleFileUploads($data, $company);
        $company->update($fileData);
        return $company->fresh();
    }

    public function update(Company $company, array $data): Company
    {
        $data = $this->prepareCompanyData($data);
        $data = $this->handleFileUploads($data, $company);
        $company->update($data);
        return $company;
    }

    public function delete(Company $company): bool
    {
        $this->deleteFiles($company);
        return $company->delete();
    }

    private function extractNonFileData(array $data): array
    {
        $fileFields = [
            'logo', 'attachment_pan', 'attachment_tan', 'attachment_gstin',
            'attachment_ckyc', 'attachment_partnership_deed', 'attachment_udyam_aadhar',
            'attachment_gumasta', 'attachment_msme'
        ];

        return array_diff_key($data, array_flip($fileFields));
    }

    private function handleFileUploads(array $data, Company $company): array
    {
        $fileFields = [
            'logo', 'attachment_pan', 'attachment_tan', 'attachment_gstin',
            'attachment_ckyc', 'attachment_partnership_deed', 'attachment_udyam_aadhar',
            'attachment_gumasta', 'attachment_msme'
        ];

        $fileData = [];
        foreach ($fileFields as $field) {
            if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                if ($company->$field) {
                    $this->fileStorageService->deleteFile($company->$field);
                }
                $fileData[$field] = $this->fileStorageService->storeCompanyDocument(
                    $company->id,
                    $data[$field],
                    str_replace('attachment_', '', $field)
                );
            }
        }

        return $fileData;
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
                $this->fileStorageService->deleteFile($company->$field);
            }
        }
    }

    public function generateCompanyCode(string $companyName): string
    {
        $baseCode = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $companyName), 0, 3));
        $counter = 1;

        do {
            $code = $baseCode . str_pad($counter, 3, '0', STR_PAD_LEFT);
            $counter++;
        } while (Company::where('code', $code)->exists());

        return $code;
    }

    public function prepareCompanyData(array $data): array
    {
        if (empty($data['code'])) {
            $data['code'] = $this->generateCompanyCode($data['name']);
        }

        return $data;
    }
}
