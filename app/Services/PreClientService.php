<?php

namespace App\Services;

use App\Models\PreClient;
use App\Models\User;
use Illuminate\Support\Str;

class PreClientService
{
    public function __construct(private FileStorageService $fileStorageService) {}

    public function getAll()
    {
        return PreClient::with(['createdBy', 'approvedBy', 'families', 'banks', 'approved2By', 'approved3By'])
            ->orderByDesc('id')->get();
    }

    public function find($id)
    {
        $client = PreClient::findOrFail($id);
        if (auth()->id() == $client->created_by) {
            $client->is_approved = true;
        } else {
            $user = User::find(auth()->id());
            if ($user->level == 1) {
                $client->is_approved = $client->approved_by != null ? true : false;
            } else if ($user->level == 2 && $client->approved_by != null) {
                $client->is_approved = $client->approved2_by != null ? true : false;
            } else if ($user->level == 3 && $client->approved2_by != null) {
                $client->is_approved = $client->approved3_by != null ? true : false;
            } else {
                $client->is_approved = true;
            }
        }
        return $client;
    }

    public function create(array $data): PreClient
    {
        $data['created_by'] = auth()->id();
        $client = PreClient::create($data);
        $data = $this->handleFileUploads($data, $client, 'A');
        $client->update($data);
        return $client;
    }

    public function update(PreClient $client, array $data): PreClient
    {
        $data = $this->handleFileUploads($data, $client, 'E');
        $client->update($data);
        return $client->fresh();
    }

    public function delete(PreClient $client): bool
    {
        $this->deleteFiles($client);
        return $client->delete();
    }

    private function handleFileUploads(array $data, PreClient $client, string $mode): array
    {
        $fileFields = [
            'attachment_client_photo',
            'attachment_pan',
            'attachment_aadhar_front',
            'attachment_aadhar_back',
            'attachment_signature',
            'attachment_ckyc',
            'attachment_other_documents'
        ];

        if ($mode == 'A') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    $data[$field] = $this->fileStorageService->storeClientDocument(
                        $client->id,
                        $data[$field . '_url'],
                        str_replace('attachment_', '', $field)
                    );
                }
            }
        } else if ($mode == 'E') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    if (Str::contains($data[$field . '_url'], 'temp')) {
                        if ($client && $client->$field) {
                            $this->fileStorageService->deleteFile($client->$field);
                        }
                        $data[$field] = $this->fileStorageService->storeClientDocument(
                            $client->id,
                            $data[$field . '_url'],
                            str_replace('attachment_', '', $field)
                        );
                    } else {
                        $data[$field] = $client->$field ?? null;
                    }
                } else {
                    if ($client && $client->$field) {
                        $this->fileStorageService->deleteFile($client->$field);
                    }
                    $data[$field] = null;
                }
            }
        }
        return $data;
    }

    private function deleteFiles(PreClient $client): void
    {
        $fileFields = [
            'attachment_client_photo',
            'attachment_pan',
            'attachment_aadhar_front',
            'attachment_aadhar_back',
            'attachment_signature',
            'attachment_ckyc',
            'attachment_other_documents'
        ];

        foreach ($fileFields as $field) {
            if ($client->$field) {
                $this->fileStorageService->deleteFile($client->$field);
            }
        }
    }
}
