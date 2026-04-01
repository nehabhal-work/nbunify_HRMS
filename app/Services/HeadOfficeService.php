<?php

namespace App\Services;

use App\Models\HeadOffice;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class HeadOfficeService
{
    // ─── List / Search ───────────────────────────────────────────────────────────

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = HeadOffice::query()->with(['company', 'createdBy', 'updatedBy']);

        if (!empty($filters['company_id'])) {
            $query->forCompany((int) $filters['company_id']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('manager_name', 'like', "%{$search}%");
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        return $query->latest()->paginate($perPage);
    }

    // ─── Create ──────────────────────────────────────────────────────────────────

    public function create(array $data): HeadOffice
    {
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        return HeadOffice::create($data);
    }

    // ─── Update ──────────────────────────────────────────────────────────────────

    public function update(HeadOffice $headOffice, array $data): HeadOffice
    {
        $data['updated_by'] = Auth::id();

        $headOffice->update($data);

        return $headOffice->fresh(['company', 'createdBy', 'updatedBy']);
    }

    // ─── Toggle Active ───────────────────────────────────────────────────────────

    public function toggleActive(HeadOffice $headOffice): HeadOffice
    {
        $headOffice->update([
            'is_active'  => !$headOffice->is_active,
            'updated_by' => Auth::id(),
        ]);

        return $headOffice->fresh();
    }

    // ─── Delete (Soft) ───────────────────────────────────────────────────────────

    public function delete(HeadOffice $headOffice): bool
    {
        return $headOffice->delete();
    }

    // ─── Force Delete ────────────────────────────────────────────────────────────

    public function forceDelete(int $id): bool
    {
        $headOffice = HeadOffice::withTrashed()->findOrFail($id);
        return $headOffice->forceDelete();
    }

    // ─── Restore ─────────────────────────────────────────────────────────────────

    public function restore(int $id): HeadOffice
    {
        $headOffice = HeadOffice::withTrashed()->findOrFail($id);
        $headOffice->restore();
        return $headOffice->fresh();
    }

    // ─── Meta Helpers ────────────────────────────────────────────────────────────

    public function updateMeta(HeadOffice $headOffice, array $meta): HeadOffice
    {
        $existing = $headOffice->meta ?? [];

        $headOffice->update([
            'meta'       => array_merge($existing, $meta),
            'updated_by' => Auth::id(),
        ]);

        return $headOffice->fresh();
    }
}
