<?php

namespace App\Services;

use App\Models\InvestmentSi;
use App\Services\FileStorageService;
use Illuminate\Database\Eloquent\Collection;

class InvestmentSiService
{
    public function __construct(
        private FileStorageService $fileStorageService
    ) {
    }

    /**
     * Get all investment SIs with relationships
     */
    public function getAll(): Collection
    {
        return InvestmentSi::with(['investment', 'siClientBank', 'siCompanyBank'])->get();
    }

    /**
     * Get investment SI by ID with relationships
     */
    public function getById(int $id): InvestmentSi
    {
        return InvestmentSi::with(['investment', 'siClientBank', 'siCompanyBank'])->findOrFail($id);
    }

    /**
     * Create a new investment SI
     */
    public function create(array $data): InvestmentSi
    {
        // Handle file uploads
        if (isset($data['attachment_si_image'])) {
            $data['attachment_si_image'] = $this->fileStorageService->store(
                $data['attachment_si_image'],
                'investment-si/si-images'
            );
        }

        if (isset($data['attachment_notes_image'])) {
            $data['attachment_notes_image'] = $this->fileStorageService->store(
                $data['attachment_notes_image'],
                'investment-si/notes-images'
            );
        }

        return InvestmentSi::create($data);
    }

    /**
     * Update an existing investment SI
     */
    public function update(InvestmentSi $investmentSi, array $data): InvestmentSi
    {
        // Handle file uploads
        if (isset($data['attachment_si_image'])) {
            // Delete old file if exists
            if ($investmentSi->attachment_si_image) {
                $this->fileStorageService->delete($investmentSi->attachment_si_image);
            }
            
            $data['attachment_si_image'] = $this->fileStorageService->store(
                $data['attachment_si_image'],
                'investment-si/si-images'
            );
        }

        if (isset($data['attachment_notes_image'])) {
            // Delete old file if exists
            if ($investmentSi->attachment_notes_image) {
                $this->fileStorageService->delete($investmentSi->attachment_notes_image);
            }
            
            $data['attachment_notes_image'] = $this->fileStorageService->store(
                $data['attachment_notes_image'],
                'investment-si/notes-images'
            );
        }

        $investmentSi->update($data);
        return $investmentSi->fresh();
    }

    /**
     * Delete an investment SI
     */
    public function delete(InvestmentSi $investmentSi): bool
    {
        // Delete associated files
        if ($investmentSi->attachment_si_image) {
            $this->fileStorageService->delete($investmentSi->attachment_si_image);
        }
        
        if ($investmentSi->attachment_notes_image) {
            $this->fileStorageService->delete($investmentSi->attachment_notes_image);
        }

        return $investmentSi->delete();
    }

    /**
     * Get investment SIs by investment ID
     */
    public function getByInvestmentId(int $investmentId): Collection
    {
        return InvestmentSi::with(['siClientBank', 'siCompanyBank'])
            ->where('investment_id', $investmentId)
            ->get();
    }
}