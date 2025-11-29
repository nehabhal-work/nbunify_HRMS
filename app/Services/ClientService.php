<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Support\Str;

class ClientService
{
    public function __construct(private FileStorageService $fileStorageService)
    {
    }

    public function getAll()
    {
        return Client::all();
    }

    public function getAllExcept(array $clientIds = [])
    {
        return Client::whereNotIn('id', [$clientIds])->get();
    }

    public function find($id) {
        return Client::findOrFail($id);
    }
    public function create(array $data): Client
    {
        $data['client_code'] = $this->generateClientCode();
        $client = Client::create($data);
        $data = $this->handleFileUploads($data, $client, 'A');
        $client->update($data);
        return $client;
    }

    public function update(Client $client, array $data): Client
    {
        $data = $this->handleFileUploads($data, $client, 'E');
        $client->update($data);
        return $client->fresh();
    }

    public function delete(Client $client): bool
    {
        $this->deleteFiles($client);
        return $client->delete();
    }

    private function handleFileUploads(array $data, Client $client, string $mode): array
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

        if($mode == 'A') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    $data[$field] = $this->fileStorageService->storeClientDocument(
                        $client->id,
                        $data[$field . '_url'],
                        str_replace('attachment_', '', $field)
                    );
                }
            }
        } else if($mode == 'E') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    if(Str::contains($data[$field . '_url'], 'temp')) {
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

    public function generateClientCode(): string
    {
        // $currentDate = now();
        // $currentYear = $currentDate->year;
        // $financialYear = $currentDate->month >= 4 ? $currentYear . '-' . ($currentYear + 1) : ($currentYear - 1) . '-' . $currentYear;

        // $baseCode = 'CC/' . $financialYear . '/';
        $baseCode = 'CL';
        $counter = 1;

        do {
            $code = $baseCode . str_pad($counter, 8, '0', STR_PAD_LEFT);
            $counter++;
        } while (Client::where('client_code', $code)->exists());

        return $code;
    }
}
