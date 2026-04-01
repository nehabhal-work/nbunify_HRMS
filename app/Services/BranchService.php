<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class BranchService
{
    // ─── List / Search ───────────────────────────────────────────────────────────

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Branch::query()
            ->with(['company', 'headOffice', 'createdBy', 'updatedBy'])
            ->ordered();

        if (!empty($filters['company_id'])) {
            $query->forCompany((int) $filters['company_id']);
        }

        if (!empty($filters['head_office_id'])) {
            $query->forHeadOffice((int) $filters['head_office_id']);
        }

        if (!empty($filters['branch_type'])) {
            $query->ofType($filters['branch_type']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
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

        return $query->paginate($perPage);
    }

    // ─── Create ──────────────────────────────────────────────────────────────────

    public function create(array $data): Branch
    {
        $data['created_by'] = Auth::id();
        $data['updated_by'] = Auth::id();

        return Branch::create($data);
    }

    // ─── Update ──────────────────────────────────────────────────────────────────

    public function update(Branch $branch, array $data): Branch
    {
        $data['updated_by'] = Auth::id();
        $branch->update($data);

        return $branch->fresh(['company', 'headOffice', 'createdBy', 'updatedBy']);
    }

    // ─── Status Change ───────────────────────────────────────────────────────────

    public function changeStatus(Branch $branch, string $status): Branch
    {
        $branch->update([
            'status'     => $status,
            'updated_by' => Auth::id(),
        ]);

        return $branch->fresh();
    }

    // ─── Reorder ─────────────────────────────────────────────────────────────────
    // Accepts: [['id' => 1, 'sort_order' => 0], ['id' => 2, 'sort_order' => 1], ...]

    public function reorder(array $items): void
    {
        foreach ($items as $item) {
            Branch::where('id', $item['id'])->update([
                'sort_order' => $item['sort_order'],
                'updated_by' => Auth::id(),
            ]);
        }
    }

    // ─── Update Opening Hours ────────────────────────────────────────────────────

    public function updateOpeningHours(Branch $branch, array $hours): Branch
    {
        $branch->update([
            'opening_hours' => $hours,
            'updated_by'    => Auth::id(),
        ]);

        return $branch->fresh();
    }

    // ─── Update Meta ─────────────────────────────────────────────────────────────

    public function updateMeta(Branch $branch, array $meta): Branch
    {
        $branch->update([
            'meta'       => array_merge($branch->meta ?? [], $meta),
            'updated_by' => Auth::id(),
        ]);

        return $branch->fresh();
    }

    // ─── Soft Delete ─────────────────────────────────────────────────────────────

    public function delete(Branch $branch): bool
    {
        return $branch->delete();
    }

    // ─── Force Delete ────────────────────────────────────────────────────────────

    public function forceDelete(int $id): bool
    {
        $branch = Branch::withTrashed()->findOrFail($id);
        return $branch->forceDelete();
    }

    // ─── Restore ─────────────────────────────────────────────────────────────────

    public function restore(int $id): Branch
    {
        $branch = Branch::withTrashed()->findOrFail($id);
        $branch->restore();
        return $branch->fresh();
    }

    // ─── Stats for a Company ─────────────────────────────────────────────────────

    public function statsForCompany(int $companyId): array
    {
        $branches = Branch::withTrashed()->forCompany($companyId);

        return [
            'total'          => (clone $branches)->count(),
            'active'         => (clone $branches)->where('status', 'active')->count(),
            'inactive'       => (clone $branches)->where('status', 'inactive')->count(),
            'closed'         => (clone $branches)->where('status', 'closed')->count(),
            'deleted'        => (clone $branches)->onlyTrashed()->count(),
            'total_employees' => (clone $branches)->whereNull('deleted_at')->sum('employee_count'),
            'by_type'        => (clone $branches)->whereNull('deleted_at')
                ->selectRaw('branch_type, count(*) as count')
                ->groupBy('branch_type')
                ->pluck('count', 'branch_type'),
        ];
    }
}
