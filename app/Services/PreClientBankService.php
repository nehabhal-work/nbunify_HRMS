<?php

namespace App\Services;

use App\Models\PreClientBank;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PreClientBankService
{
    public function __construct(private FileStorageService $fileStorageService) {}

    public function getByPreClientId($preclientId)
    {
        return PreClientBank::where('preclient_id', $preclientId)->get();
    }

    public function getById($id)
    {
        return PreClientBank::findOrFail($id);
    }

    public function create(array $data)
    {
        if ($data['account_number'] == null) {
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
            'attachment_cancelled_cheque_url' => 'nullable|string',
            'operation_mode' => 'nullable|string',
            'holder_name_1' => 'nullable|string',
            'holder_name_2' => 'nullable|string',
            'holder_name_3' => 'nullable|string',
            'micrcode' => 'nullable|string',
        ]);

        $preClientBank = PreClientBank::create([
            'preclient_id' => $data['preclient_id'],
            'account_number' => $data['account_number'],
            'ifsc_code' => $data['ifsc_code'],
            'bank_name' => $data['bank_name'],
            'branch_name' => $data['branch_name'],
            'bank_code' => $data['bank_code'],
            'is_primary' => $data['is_primary'] ?? 0,
            'account_type' => $data['account_type'] ?? null,
            'operation_mode' => $data['operation_mode'] ?? null,
            'holder_name_1' => $data['holder_name_1'] ?? null,
            'holder_name_2' => $data['holder_name_2'] ?? null,
            'holder_name_3' => $data['holder_name_3'] ?? null,
            'micrcode' => $data['micrcode'] ?? null,
        ]);

        if (isset($data['attachment_cancelled_cheque_url'])) {
            $preClientBank->attachment_cancelled_cheque = $this->fileStorageService->storeClientDocument(
                $data['preclient_id'],
                $data['attachment_cancelled_cheque_url'],
                'cancelled_cheque'
            );
            $preClientBank->save();
        }

        return $preClientBank;
    }

    public function update($preClientBank, array $data)
    {
        Validator::validate($data, [
            'account_number' => 'required|string|max:20',
            'ifsc_code' => 'required|string|max:11',
            'bank_name' => 'required|string',
            'branch_name' => 'required|string',
            'bank_code' => 'nullable|string|max:255',
            'is_primary' => 'boolean',
            'account_type' => 'nullable|in:savings,current,od_cc,nre,nri,nro,tem_deposit,ra',
            'attachment_cancelled_cheque_url' => 'nullable|string',
            'operation_mode' => 'nullable|string',
            'holder_name_1' => 'nullable|string',
            'holder_name_2' => 'nullable|string',
            'holder_name_3' => 'nullable|string',
            'micrcode' => 'nullable|string',
        ]);

        $updateData = [
            'account_number' => $data['account_number'],
            'ifsc_code' => $data['ifsc_code'],
            'bank_name' => $data['bank_name'],
            'branch_name' => $data['branch_name'],
            'bank_code' => $data['bank_code'] ?? null,
            'is_primary' => $data['is_primary'] ?? 0,
            'account_type' => $data['account_type'] ?? null,
            'operation_mode' => $data['operation_mode'] ?? null,
            'holder_name_1' => $data['holder_name_1'] ?? null,
            'holder_name_2' => $data['holder_name_2'] ?? null,
            'holder_name_3' => $data['holder_name_3'] ?? null,
            'micrcode' => $data['micrcode'] ?? null,
        ];

        if (isset($data['attachment_cancelled_cheque_url'])) {
            if (Str::contains($data['attachment_cancelled_cheque_url'], 'temp')) {
                if ($preClientBank->attachment_cancelled_cheque) {
                    $this->fileStorageService->deleteFile($preClientBank->attachment_cancelled_cheque);
                }
                $updateData['attachment_cancelled_cheque'] = $this->fileStorageService->storeClientDocument(
                    $preClientBank->preclient_id,
                    $data['attachment_cancelled_cheque_url'],
                    'cancelled_cheque'
                );
            }
        } else {
            if ($preClientBank->attachment_cancelled_cheque) {
                $this->fileStorageService->deleteFile($preClientBank->attachment_cancelled_cheque);
            }
            $updateData['attachment_cancelled_cheque'] = null;
        }

        return $preClientBank->update($updateData);
    }

    public function delete($id)
    {
        $preClientBank = PreClientBank::findOrFail($id);
        
        if ($preClientBank->attachment_cancelled_cheque) {
            $this->fileStorageService->deleteFile($preClientBank->attachment_cancelled_cheque);
        }
        $preClientBank->delete();
    }

    public function deleteByPreClientId($preclientId)
    {
        $preClientBanks = PreClientBank::where('preclient_id', $preclientId)->get();
        foreach ($preClientBanks as $preClientBank) {
            if ($preClientBank->attachment_cancelled_cheque) {
                $this->fileStorageService->deleteFile($preClientBank->attachment_cancelled_cheque);
            }
        }
        PreClientBank::where('preclient_id', $preclientId)->delete();
    }

    public function addFileUrls($preClientBank)
    {
        $fileFields = [
            'attachment_cancelled_cheque'
        ];

        foreach ($fileFields as $field) {
            if ($preClientBank->$field) {
                $preClientBank->{$field . '_url'} =
                    app(FileStorageService::class)->getTemporaryUrl($preClientBank->$field);
            }
        }

        return $preClientBank;
    }
}