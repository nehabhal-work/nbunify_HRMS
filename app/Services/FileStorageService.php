<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FileStorageService
{
    public function storeCompanyDocument(int $companyId, string $tempUrl, string $type = 'general'): string
    {
        $response = Http::get($tempUrl);
        $extension = pathinfo(parse_url($tempUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'tmp';
        $filename = Str::uuid() . '.' . $extension;
        $path = "companies/{$companyId}/{$type}/{$filename}";

        Storage::disk('wasabi')->put($path, $response->body());

        return $path;
    }

    public function storeClientDocument(int $clientId, string $tempUrl, string $type = 'general'): string
    {
        $response = Http::get($tempUrl);
        $extension = pathinfo(parse_url($tempUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'tmp';
        $filename = Str::uuid() . '.' . $extension;
        $path = "clients/{$clientId}/{$type}/{$filename}";

        Storage::disk('wasabi')->put($path, $response->body());

        return $path;
    }

    public function storeEmployeeDocument(int $employeeId, string $tempUrl, string $type = 'general'): string
    {
        $response = Http::get($tempUrl);
        $extension = pathinfo(parse_url($tempUrl, PHP_URL_PATH), PATHINFO_EXTENSION) ?: 'tmp';
        $filename = Str::uuid() . '.' . $extension;
        $path = "employees/{$employeeId}/{$type}/{$filename}";

        Storage::disk('wasabi')->put($path, $response->body());

        return $path;
    }

    public function getTemporaryUrl(string $path, int $minutes = 30): string
    {
        return Storage::disk('wasabi')->temporaryUrl($path, now()->addMinutes($minutes));
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
