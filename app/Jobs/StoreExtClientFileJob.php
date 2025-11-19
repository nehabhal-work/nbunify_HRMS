<?php

namespace App\Jobs;

use App\Models\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FileStorageService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class StoreExtClientFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public string $tempUrl;
    public string $storagePath;
    public string $clientId;
    public string $field;

    /**
     * Create a new job instance.
     */
    public function __construct(string $tempUrl, string $storagePath, int $clientId, string $field)
    {
        $this->tempUrl = $tempUrl;
        $this->storagePath = $storagePath;
        $this->clientId = $clientId;
        $this->field = $field;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $response = Http::timeout(30)->get($this->tempUrl);
            if (!$response->successful()) {
                throw new \Exception("Failed to download temp file: " . $this->tempUrl);
            }
            if(Storage::disk('wasabi')->put($this->storagePath, $response->body())) {
                Client::findOrFail($this->clientId)->update([
                    $this->field => $this->storagePath,
                ]);
            }
        } catch (\Throwable $e) {
            logger()->error("Document upload failed: {$e->getMessage()}");
            throw $e;
        }
    }
}
