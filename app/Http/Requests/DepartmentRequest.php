<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class DepartmentService
{
    // ─── List / Search (flat paginated) ─────────────────────────────────────────

    public function paginate(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Department::query()
            ->with(['company', 'branch', 'headOffice', 'parent'])
            ->ordered();

        if (!empty($filters['company_id'])) {
            $query->forCompany((int) $filters['company_id']);
        }

        if (!empty($filters['branch_id'])) {
            $query->forBranch((int) $filters['branch_id']);
        }

        if (!empty($filters['head_office_id'])) {
            $query->forHeadOffice((int) $filters['head_office_id']);
        }

        if (!empty($filters['dept_type'])) {
            $query->ofType($filters['dept_type']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', filter_var($filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        if (isset($filters['roots_only']) && filter_var($filters['roots_only'], FILTER_VALIDATE_BOOLEAN)) {
            $query->roots();
        }

        if (!empty($filters['parent_id'])) {
            $query->where('parent_id', $filters['parent_id']);
        }

        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('code', 'like', "%{$s}%")
                    ->orWhere('head_name', 'like', "%{$s}%")
                    ->orWhere('cost_centre', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%");
            });
        }

        return $query->paginate($perPage);
    }

    // ─── Full Tree (nested) ──────────────────────────────────────────────────────

    public function tree(int $companyId, ?int $branchId = null, ?int $headOfficeId = null): Collection
    {
        $query = Department::with('childrenRecursive')
            ->forCompany($companyId)
            ->roots()
            ->ordered();

        if ($branchId) {
            $query->forBranch($branchId);
        }

        if ($headOfficeId) {
            $query->forHeadOffice($headOfficeId);
        }

        return $query->get();
    }

    // ─── Create ──────────────────────────────────────────────────────────────────

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    // ─── Update ──────────────────────────────────────────────────────────────────

    public function update(Department $department, array $data): Department
    {
        $department->update($data);

        return $department->fresh(['company', 'branch', 'headOffice', 'parent', 'children']);
    }

    // ─── Toggle Active ───────────────────────────────────────────────────────────

    public function toggleActive(Department $department): Department
    {
        $department->update(['is_active' => !$department->is_active]);

        return $department->fresh();
    }

    // ─── Move (change parent) ────────────────────────────────────────────────────

    public function move(Department $department, ?int $newParentId): Department
    {
        if ($newParentId && $department->wouldCreateCycle($newParentId)) {
            throw new \InvalidArgumentException('Moving this department would create a circular reference.');
        }

        $department->update(['parent_id' => $newParentId]);

        return $department->fresh(['parent', 'children']);
    }

    // ─── Reorder ─────────────────────────────────────────────────────────────────

    public function reorder(array $items): void
    {
        foreach ($items as $item) {
            Department::where('id', $item['id'])->update([
                'sort_order' => $item['sort_order'],
            ]);
        }
    }

    // ─── Update Meta ─────────────────────────────────────────────────────────────

    public function updateMeta(Department $department, array $meta): Department
    {
        $department->update([
            'meta' => array_merge($department->meta ?? [], $meta),
        ]);

        return $department->fresh();
    }

    // ─── Soft Delete ─────────────────────────────────────────────────────────────

    public function delete(Department $department): bool
    {
        return $department->delete();
    }

    // ─── Force Delete ────────────────────────────────────────────────────────────

    public function forceDelete(int $id): bool
    {
        $department = Department::withTrashed()->findOrFail($id);
        return $department->forceDelete();
    }

    // ─── Restore ─────────────────────────────────────────────────────────────────

    public function restore(int $id): Department
    {
        $department = Department::withTrashed()->findOrFail($id);
        $department->restore();
        return $department->fresh();
    }

    // ─── Stats ───────────────────────────────────────────────────────────────────

    public function statsForCompany(int $companyId): array
    {
        $base = Department::withTrashed()->forCompany($companyId);

        return [
            'total'           => (clone $base)->count(),
            'active'          => (clone $base)->whereNull('deleted_at')->where('is_active', true)->count(),
            'inactive'        => (clone $base)->whereNull('deleted_at')->where('is_active', false)->count(),
            'deleted'         => (clone $base)->onlyTrashed()->count(),
            'root_depts'      => (clone $base)->whereNull('deleted_at')->whereNull('parent_id')->count(),
            'child_depts'     => (clone $base)->whereNull('deleted_at')->whereNotNull('parent_id')->count(),
            'total_employees' => (clone $base)->whereNull('deleted_at')->sum('employee_count'),
            'total_budget'    => (clone $base)->whereNull('deleted_at')->sum('budget'),
            'by_type'         => (clone $base)->whereNull('deleted_at')
                ->selectRaw('dept_type, count(*) as count')
                ->groupBy('dept_type')
                ->pluck('count', 'dept_type'),
        ];
    }
}
