<?php

namespace App\Services;

use App\Models\Company;
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

            // 1️⃣ Create Company
            $company = Company::create($data);

            // 2️⃣ Create Head Office (Registered Address)
            HeadOffice::create([
                'company_id'     => $company->id,
                'name'           => $company->name . ' Head Office',
                'code'           => 'HO-1', // you can make dynamic later
                'email'          => $data['email'] ?? 'default@email.com',

                'address_line_1' => $data['reg_address_line1'] ?? null,
                'address_line_2' => $data['reg_address_line2'] ?? null,
                'city'           => $data['reg_city'] ?? null,
                'state'          => $data['reg_state'] ?? null,
                'country'        => $data['reg_country'] ?? 'India',
                'pincode'        => $data['reg_pincode'] ?? null,

                'created_by'     => Auth::id(),
                'updated_by'     => Auth::id(),
            ]);

            return $company;
        });
    }


    $('#sameAddress').on('change', function() {

                if ($(this).is(':checked')) {

                    // Copy values
                    $('input[name="op_address_line1"]').val($('input[name="reg_address_line1"]').val());
                    $('input[name="op_address_line2"]').val($('input[name="reg_address_line2"]').val());
                    $('input[name="op_city"]').val($('input[name="reg_city"]').val());
                    $('input[name="op_pincode"]').val($('input[name="reg_pincode"]').val());

                    $('select[name="op_state"]').val($('select[name="reg_state"]').val());
                    $('select[name="op_country"]').val($('select[name="reg_country"]').val());

                } else {

                    // Clear values when unchecked
                    $('input[name="op_address_line1"]').val('');
                    $('input[name="op_address_line2"]').val('');
                    $('input[name="op_city"]').val('');
                    $('input[name="op_pincode"]').val('');

                    $('select[name="op_state"]').val('');
                    $('select[name="op_country"]').val('');

                }

            });

            
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
