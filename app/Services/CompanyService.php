<?php

namespace App\Services;

use App\Models\Company;
use App\Models\CompanyBank;
use App\Models\HeadOffice;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyService
{
    // ─── File Upload Fields ──────────────────────────────────────────────────────

    const FILE_FIELDS = [
        'logo'                        => 'companies/logos',
        'attachment_pan'              => 'companies/attachments/pan',
        'attachment_tan'              => 'companies/attachments/tan',
        'attachment_gstin'            => 'companies/attachments/gstin',
        'attachment_ckyc'             => 'companies/attachments/ckyc',
        'attachment_partnership_deed' => 'companies/attachments/partnership_deed',
        'attachment_udyam_aadhar'     => 'companies/attachments/udyam_aadhar',
        'attachment_gumasta'          => 'companies/attachments/gumasta',
        'attachment_msme'             => 'companies/attachments/msme',
    ];

    // ─── List / Search ───────────────────────────────────────────────────────────

    public function getAll()
    {
        return Company::with(['createdBy', 'updatedBy'])->get();
    }

    public function getById(int $id): ?Company
    {
        $company = Company::with(['headOffices', 'companyBank'])->findOrFail($id);
        return $company;
    }
    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Company::query()->with(['createdBy', 'updatedBy']);

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('legal_name', 'like', "%{$search}%")
                    ->orWhere('pan_no', 'like', "%{$search}%")
                    ->orWhere('gstin', 'like', "%{$search}%")
                    ->orWhere('cin_no', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['company_type'])) {
            $query->where('company_type', $filters['company_type']);
        }

        return $query->latest()->paginate($perPage);
    }

    // ─── Create ──────────────────────────────────────────────────────────────────

    public function create(array $data): Company
    {
        return DB::transaction(function () use ($data) {

            // Handle file uploads
            $data = $this->handleFileUploads($data);

            // Add audit fields
            $data['created_by'] = Auth::id();
            $data['updated_by'] = Auth::id();

            // Fix website
            if (!empty($data['website'])) {
                $data['website'] = 'https://' . preg_replace('#^https?://#', '', $data['website']);
            }

            // Extract banks separately
            $banks = $data['banks'] ?? [];
            unset($data['banks']);

            // Remove address fields from company
            $companyData = collect($data)->except([
                'op_address_line1',
                'op_address_line2',
                'op_city',
                'op_state',
                'op_country',
                'op_pincode',
            ])->toArray();

            // dd($companyData, $banks);
            // 1️⃣ Create Company
            $company = Company::create($companyData);

            // 2️⃣ Create Head Office
            HeadOffice::create([
                'company_id'     => $company->id,
                'name'           => $company->name . ' Head Office',
                'code'           => 'HO-1',
                'email'          => $data['email'] ?? '',

                'address_line_1' => $data['op_address_line1'] ?? null,
                'address_line_2' => $data['op_address_line2'] ?? null,
                'city'           => $data['op_city'] ?? null,
                'state'          => $data['op_state'] ?? null,
                'country'        => $data['op_country'] ?? 'India',
                'pincode'        => $data['op_pincode'] ?? null,

                'created_by'     => Auth::id(),
                'updated_by'     => Auth::id(),
            ]);

            // 3️⃣ Save Multiple Banks
            // dd($banks);
            if (!empty($banks)) {
                foreach ($banks as $bank) {

                    // skip empty rows
                    if (empty($bank['account_number']) && empty($bank['ifsc_code'])) {
                        continue;
                    }

                    CompanyBank::create([
                        'company_id'     => $company->id,
                        'bank_name'      => $bank['bank_name'] ?? null,
                        'branch_name'    => $bank['branch_name'] ?? null,
                        'ifsc_code'      => $bank['ifsc_code'] ?? null,
                        'account_number' => $bank['account_number'] ?? null,
                        'account_type'   => $bank['account_type'] ?? null,
                        'bank_code'      => $bank['bank_code'] ?? null,
                        'is_primary'     => $bank['is_primary'] ?? 0,

                        'created_by'     => Auth::id(),
                        'updated_by'     => Auth::id(),
                    ]);
                }
            }

            return $company;
        });
    }





    // ─── Update ──────────────────────────────────────────────────────────────────

    public function update(Company $company, array $data): Company
    {
        $data = $this->handleFileUploads($data, $company);
        $data['updated_by'] = Auth::id();

        $company->update($data);

        return $company->fresh();
    }

    // ─── Delete ──────────────────────────────────────────────────────────────────

    public function delete(Company $company): bool
    {
        return $company->delete();
    }

    public function forceDelete(Company $company): bool
    {
        $this->deleteAllFiles($company);
        return $company->forceDelete();
    }

    public function restore(int $id): ?Company
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return $company;
    }

    // ─── File Handling ───────────────────────────────────────────────────────────

    private function handleFileUploads(array $data, ?Company $existing = null): array
    {
        foreach (self::FILE_FIELDS as $field => $folder) {
            if (!isset($data[$field]) || !($data[$field] instanceof UploadedFile)) {
                unset($data[$field]); // Don't overwrite existing path if no new file
                continue;
            }

            // Delete old file if replacing
            if ($existing && $existing->{$field}) {
                Storage::disk('public')->delete($existing->{$field});
            }

            $data[$field] = $data[$field]->store($folder, 'public');
        }

        return $data;
    }

    private function deleteAllFiles(Company $company): void
    {
        foreach (array_keys(self::FILE_FIELDS) as $field) {
            if ($company->{$field}) {
                Storage::disk('public')->delete($company->{$field});
            }
        }
    }

    public function deleteFile(Company $company, string $field): bool
    {
        if (!array_key_exists($field, self::FILE_FIELDS)) {
            return false;
        }

        if ($company->{$field}) {
            Storage::disk('public')->delete($company->{$field});
            $company->update([$field => null, 'updated_by' => Auth::id()]);
        }

        return true;
    }
}
