<?php

namespace App\Services;

use App\Jobs\StoreFileJob;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FileStorageService
{
    public function storeCompanyDocument(int $companyId, string $tempUrl, string $type = 'general'): string
    {
        $extension = pathinfo(parse_url($tempUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'tmp';
        $filename = Str::uuid() . '.' . $extension;
        $path = "companies/{$companyId}/{$type}/{$filename}";
        StoreFileJob::dispatch($tempUrl, $path);
        return $path;
    }

    public function storeClientDocument(int $clientId, string $tempUrl, string $type = 'general'): string
    {
        $extension = pathinfo(parse_url($tempUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'tmp';
        $filename = Str::uuid() . '.' . $extension;
        $path = "clients/{$clientId}/{$type}/{$filename}";
        StoreFileJob::dispatch($tempUrl, $path);
        return $path;
    }

    public function storeEmployeeDocument(int $employeeId, string $tempUrl, string $type = 'general'): string
    {
        $extension = pathinfo(parse_url($tempUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'tmp';
        $filename = Str::uuid() . '.' . $extension;
        $path = "employees/{$employeeId}/{$type}/{$filename}";
        StoreFileJob::dispatch($tempUrl, $path);
        return $path;
    }

    public function getTemporaryUrl(string $path, int $minutes = 30): string
    {
        return Storage::disk('wasabi')->temporaryUrl($path, now()->addMinutes($minutes));
    }

    public function uploadToWasabi(string $tempUrl, string $storagePath) {
        try {
            $response = Http::timeout(30)->get($tempUrl);
            if (!$response->successful()) {
                throw new \Exception("Failed to download temp file: " . $tempUrl);
            }
            Storage::disk('wasabi')->put($storagePath, $response->body());
        } catch (\Throwable $e) {
            // log or rethrow so the job fails and retries
            logger()->error("Document upload failed: {$e->getMessage()}");
            throw $e;
        }
    }

    public function deleteFile(string $path): bool
    {
        return Storage::disk('wasabi')->delete($path);
    }

    public function fileExists(string $path): bool
    {
        return Storage::disk('wasabi')->exists($path);
    }

    public function getFileSize(string $path): int
    {
        return Storage::disk('wasabi')->size($path);
    }
}
