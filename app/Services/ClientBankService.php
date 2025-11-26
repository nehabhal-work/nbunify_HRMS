<?php

namespace App\Services;

use App\Models\ClientBank;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ClientBankService
{
    public function __construct(private FileStorageService $fileStorageService)
    {
    }
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
            'attachment_cancelled_cheque_url' => 'nullable|string',
            'operation_mode' => 'nullable|string',
            'holder_name_1' => 'nullable|string',
            'holder_name_2' => 'nullable|string',
            'holder_name_3' => 'nullable|string',
            'micrcode' => 'nullable|string',
        ]);

        $clientBank = ClientBank::create([
            'client_id' => $data['client_id'],
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
            $clientBank->attachment_cancelled_cheque = $this->fileStorageService->storeClientDocument(
                $data['client_id'],
                $data['attachment_cancelled_cheque_url'],
                'cancelled_cheque'
            );
            $clientBank->save();
        }

        return $clientBank;
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
                if ($clientBank->attachment_cancelled_cheque) {
                    $this->fileStorageService->deleteFile($clientBank->attachment_cancelled_cheque);
                }
                $updateData['attachment_cancelled_cheque'] = $this->fileStorageService->storeClientDocument(
                    $clientBank->client_id,
                    $data['attachment_cancelled_cheque_url'],
                    'cancelled_cheque'
                );
            }
        } else {
            if ($clientBank->attachment_cancelled_cheque) {
                $this->fileStorageService->deleteFile($clientBank->attachment_cancelled_cheque);
            }
            $updateData['attachment_cancelled_cheque'] = null;
        }

        return $clientBank->update($updateData);
    }

    public function delete($id)
    {
        $clientBank = ClientBank::findOrFail($id);
        if ($clientBank->attachment_cancelled_cheque) {
            $this->fileStorageService->deleteFile($clientBank->attachment_cancelled_cheque);
        }
        $clientBank->delete();
    }

    public function deleteByClientId($clientId)
    {
        $clientBanks = ClientBank::where('client_id', $clientId)->get();
        foreach ($clientBanks as $clientBank) {
            if ($clientBank->attachment_cancelled_cheque) {
                $this->fileStorageService->deleteFile($clientBank->attachment_cancelled_cheque);
            }
        }
        ClientBank::where('client_id', $clientId)->delete();
    }
}