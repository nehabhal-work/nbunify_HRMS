<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\FileStorageService;

class StoreFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public string $tempUrl;
    public string $storagePath;

    /**
     * Create a new job instance.
     */
    public function __construct(string $tempUrl, string $storagePath)
    {
        $this->tempUrl = $tempUrl;
        $this->storagePath = $storagePath;
    }

    /**
     * Execute the job.
     */
    public function handle(FileStorageService $fileStorageService): void
    {
        $fileStorageService->uploadToWasabi($this->tempUrl, $this->storagePath);
    }
}
