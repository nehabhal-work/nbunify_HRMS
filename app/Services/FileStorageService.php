<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileStorageService
{
    public function storeCompanyDocument(int $companyId, UploadedFile $file, string $type = 'general'): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "companies/{$companyId}/{$type}/{$filename}";

        Storage::disk('wasabi')->put($path, file_get_contents($file));

        return $path;
    }

    public function storeClientDocument(int $clientId, UploadedFile $file, string $type = 'general'): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "clients/{$clientId}/{$type}/{$filename}";

        Storage::disk('wasabi')->put($path, file_get_contents($file));

        return $path;
    }

    public function storeEmployeeDocument(int $employeeId, UploadedFile $file, string $type = 'general'): string
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = "employees/{$employeeId}/{$type}/{$filename}";

        Storage::disk('wasabi')->put($path, file_get_contents($file));

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
