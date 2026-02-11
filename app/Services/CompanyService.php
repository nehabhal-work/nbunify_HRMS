<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Support\Str;

class CompanyService
{
    public function __construct(private FileStorageService $fileStorageService) {}

    public function getAll()
    {
        return Company::all();
    }

    public function getFirstCompanyBanks()
    {
        $company = Company::with('bankDetails')->first();
        return $company ? $company->bankDetails : [];
    }

    public function find($id)
    {
        return Company::findOrFail($id);
    }

    public function findFirstOrFail()
    {
        return Company::with('bankDetails')->firstOrFail();
    }

    public function create(array $data): Company
    {
        $data = $this->prepareCompanyData($data);
        $company = Company::create($data);
        $data = $this->handleFileUploads($data, $company, 'A');
        $company->update($data);
        return $company;
    }

    public function update(Company $company, array $data): Company
    {
        $data = $this->prepareCompanyData($data);
        $data = $this->handleFileUploads($data, $company, 'E');
        $company->update($data);
        return $company->fresh();
    }

    public function delete(Company $company): bool
    {
        $this->deleteFiles($company);
        return $company->delete();
    }

    private function handleFileUploads(array $data, Company $company, string $mode): array
    {
        $fileFields = [
            'logo',
            'attachment_pan',
            'attachment_tan',
            'attachment_gstin',
            'attachment_ckyc',
            'attachment_partnership_deed',
            'attachment_udyam_aadhar',
            'attachment_gumasta',
            'attachment_msme',
            'attachment_aadhar'
        ];

        if ($mode == 'A') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    $data[$field] = $this->fileStorageService->storeCompanyDocument(
                        $company->id,
                        $data[$field . '_url'],
                        str_replace('attachment_', '', $field)
                    );
                }
            }
        } else if ($mode == 'E') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    if (Str::contains($data[$field . '_url'], 'temp')) {
                        if ($company && $company->$field) {
                            $this->fileStorageService->deleteFile($company->$field);
                        }
                        $data[$field] = $this->fileStorageService->storeCompanyDocument(
                            $company->id,
                            $data[$field . '_url'],
                            str_replace('attachment_', '', $field)
                        );
                    } else {
                        $data[$field] = $company->$field ?? null;
                    }
                } else {
                    if ($company && $company->$field) {
                        $this->fileStorageService->deleteFile($company->$field);
                    }
                    $data[$field] = null;
                }
            }
        }
        return $data;
    }

    private function deleteFiles(Company $company): void
    {
        $fileFields = [
            'logo',
            'attachment_pan',
            'attachment_tan',
            'attachment_gstin',
            'attachment_ckyc',
            'attachment_partnership_deed',
            'attachment_udyam_aadhar',
            'attachment_gumasta',
            'attachment_msme',
            'attachment_aadhar'
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
