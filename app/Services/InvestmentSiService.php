<?php

namespace App\Services;

use App\Models\InvestmentSi;
use App\Services\FileStorageService;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
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

    public function showById(int $id): InvestmentSi
    {
        $investmentSi = InvestmentSi::with([
            'investment',
            'siClientBank',
            'siCompanyBank',
            'createdBy',
            'approvedBy'
        ])->findOrFail($id);

        // Set is_approved based on user level and approval status
        if (auth()->id() == $investmentSi->created_by) {
            $investmentSi->is_approved = true;
        } else {
            $investmentSi->is_approved = $investmentSi->approved_by != null;
        }
        return $investmentSi;
    }

    /**
     * Get investment SI by ID with relationships
     */
    public function getById(int $id): InvestmentSi
    {
        return InvestmentSi::with([
            'investment',
            'siClientBank',
            'siCompanyBank',
            'createdBy',
            'approvedBy'
        ])->findOrFail($id);
    }

    /**
     * Create a new investment SI
     */
    public function create(array $data): InvestmentSi
    {
        $investmentSi = InvestmentSi::create($data);

        // Handle file uploads after creating the record to get the ID
        if (isset($data['attachment_si_image'])) {
            $path = $this->fileStorageService->storeInvestmentDocument(
                $investmentSi->id,
                $data['attachment_si_image'],
                'si-images'
            );
            $investmentSi->update(['attachment_si_image' => $path]);
        }

        if (isset($data['attachment_notes_image'])) {
            $path = $this->fileStorageService->storeInvestmentDocument(
                $investmentSi->id,
                $data['attachment_notes_image'],
                'notes-images'
            );
            $investmentSi->update(['attachment_notes_image' => $path]);
        }

        return $investmentSi->fresh();
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
                $this->fileStorageService->deleteFile($investmentSi->attachment_si_image);
            }

            $data['attachment_si_image'] = $this->fileStorageService->storeInvestmentDocument(
                $investmentSi->id,
                $data['attachment_si_image'],
                'si-images'
            );
        }

        if (isset($data['attachment_notes_image'])) {
            // Delete old file if exists
            if ($investmentSi->attachment_notes_image) {
                $this->fileStorageService->deleteFile($investmentSi->attachment_notes_image);
            }

            $data['attachment_notes_image'] = $this->fileStorageService->storeInvestmentDocument(
                $investmentSi->id,
                $data['attachment_notes_image'],
                'notes-images'
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
            $this->fileStorageService->deleteFile($investmentSi->attachment_si_image);
        }

        if ($investmentSi->attachment_notes_image) {
            $this->fileStorageService->deleteFile($investmentSi->attachment_notes_image);
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
