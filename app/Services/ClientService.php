<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ClientService
{
    public function __construct(private FileStorageService $fileStorageService)
    {
    }

    public function getAll()
    {
        return Client::all();
    }

    public function find($id) {
        return Client::findOrFail($id);
    }
    public function create(array $data): Client
    {
        $data['client_code'] = Client::generateClientCode();
        $client = Client::create($data);
        $data = $this->handleFileUploads($data, $client);
        return $client;
    }

    public function update(Client $client, array $data): Client
    {
        $data = $this->handleFileUploads($data, $client);
        $client->update($data);
        return $client->fresh();
    }

    public function delete(Client $client): bool
    {
        $this->deleteFiles($client);
        return $client->delete();
    }

    private function handleFileUploads(array $data, Client $client): array
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
            if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                if ($client && $client->$field) {
                    $this->fileStorageService->deleteFile($client->$field);
                }
                $data[$field] = $this->fileStorageService->storeClientDocument(
                    $client->id,
                    $data[$field],
                    str_replace('attachment_', '', $field)
                );
            }
        }

        return $data;
    }

    private function deleteFiles(Client $client): void
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
