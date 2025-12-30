<?php

namespace App\Services;

use App\Models\AccountVendor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AccountVendorService
{
    public function __construct(private FileStorageService $fileStorageService) {}

    public function getAll()
    {
        return AccountVendor::with(['createdBy', 'approvedBy', 'approved2By', 'approved3By'])
            ->orderByDesc('id')->get();
    }



    public function find($id)
    {
        // return $id;
        $vendor = AccountVendor::findOrFail($id);
        if (auth()->id() == $vendor->created_by) {
            $vendor->is_approved = true;
        } else {
            $user = User::find(auth()->id());
            if ($user->level == 1) {
                $vendor->is_approved = $vendor->approved_by != null ? true : false;
            } else if ($user->level == 2 && $vendor->approved_by != null) {
                $vendor->is_approved = $vendor->approved2_by != null ? true : false;
            } else if ($user->level == 3 && $vendor->approved2_by != null) {
                $vendor->is_approved = $vendor->approved3_by != null ? true : false;
            } else {
                $vendor->is_approved = true;
            }
        }
        return $vendor;
    }

    public function create(array $data)
    {
        $data['vendor_code'] = $this->generateClientCode();
        $data['created_by'] = Auth::id();
        $vendor = AccountVendor::create($data);
        $data = $this->handleFileUploads($data, $vendor, 'A');
        $vendor->update($data);
        return $vendor;
    }

    public function approve($id)
    {
        $vendor = AccountVendor::findOrFail($id);
        $user = User::find(auth()->id());
        if ($vendor != null) {
            if ($user->level == 1) {
                $vendor->approved_by = auth()->id();
                $vendor->approved_at = now();
                $vendor->save();
            } else if ($user->level == 2) {
                $vendor->approved2_by = auth()->id();
                $vendor->approved2_on = now();
                $vendor->save();
            } else if ($user->level == 3) {
                $vendor->approved3_by = auth()->id();
                $vendor->approved3_on = now();
                $vendor->save();
            } else {
                return abort(401, 'User level not found');
            }
        } else {
            return abort(404, 'Vendor Not Found');
        }
    }

    public function update(AccountVendor $vendor, array $data): AccountVendor
    {
        $data;
        $data = $this->handleFileUploads(
            $data,
            $vendor,
            'E'
        );
        $vendor->update($data);
        return $vendor->fresh();
    }


    public function delete(AccountVendor $vendor): bool
    {
        $this->deleteFiles($vendor);
        return $vendor->delete();
    }

    private function handleFileUploads(array $data, AccountVendor $vendor, string $mode): array
    {
        $fileFields = [
            'attachment_client_photo',
            'attachment_pan',
            'attachement_aadhar',
            'attachment_gst',
            'attachment_other_documents',
            'attachment_cancelled_cheque'
        ];

        if ($mode == 'A') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    $data[$field] = $this->fileStorageService->storeClientDocument(
                        $vendor->id,
                        $data[$field . '_url'],
                        str_replace('attachment_', '', $field)
                    );
                }
            }
        } else if ($mode == 'E') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    if (Str::contains($data[$field . '_url'], 'temp')) {
                        if ($vendor && $vendor->$field) {
                            $this->fileStorageService->deleteFile($vendor->$field);
                        }
                        $data[$field] = $this->fileStorageService->storeClientDocument(
                            $vendor->id,
                            $data[$field . '_url'],
                            str_replace('attachment_', '', $field)
                        );
                    } else {
                        $data[$field] = $vendor->$field ?? null;
                    }
                } else {
                    if ($vendor && $vendor->$field) {
                        $this->fileStorageService->deleteFile($vendor->$field);
                    }
                    $data[$field] = null;
                }
            }
        }
        return $data;
    }

    private function deleteFiles(AccountVendor $vendor): void
    {
        $fileFields = [
            'attachment_client_photo',
            'attachment_pan',
            'attachement_aadhar',
            'attachment_gst',
            'attachment_other_documents',
            'attachment_cancelled_cheque'
        ];

        foreach ($fileFields as $field) {
            if ($vendor->$field) {
                $this->fileStorageService->deleteFile($vendor->$field);
            }
        }
    }



    public function generateClientCode(): string
    {
        $baseCode = 'VND';
        $counter = 1;

        do {
            $code = $baseCode . str_pad($counter, 4, '0', STR_PAD_LEFT);
            $counter++;
        } while (AccountVendor::where('vendor_code', $code)->exists());

        return $code;
    }
}
