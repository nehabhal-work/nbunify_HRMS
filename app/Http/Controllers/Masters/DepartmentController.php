<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function __construct(protected DepartmentService $departmentService) {}

    /**
     * GET /departments
     * Filters: ?company_id= &branch_id= &head_office_id= &dept_type=
     *          &is_active= &parent_id= &roots_only=1 &search= &per_page=
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only([
            'company_id',
            'branch_id',
            'head_office_id',
            'dept_type',
            'is_active',
            'parent_id',
            'roots_only',
            'search',
        ]);

        $departments = $this->departmentService->paginate($filters, $request->integer('per_page', 15));

        return response()->json([
            'success' => true,
            'data'    => $departments,
        ]);
    }

    /**
     * GET /departments/tree?company_id=1&branch_id=&head_office_id=
     * Returns fully nested tree structure
     */
    public function tree(Request $request): JsonResponse
    {
        $request->validate([
            'company_id' => ['required', 'integer', 'exists:companies,id'],
        ]);

        $tree = $this->departmentService->tree(
            (int) $request->input('company_id'),
            $request->integer('branch_id') ?: null,
            $request->integer('head_office_id') ?: null,
        );

        return response()->json([
            'success' => true,
            'data'    => $tree,
        ]);
    }

    /**
     * GET /departments/stats?company_id=1
     */
    public function stats(Request $request): JsonResponse
    {
        $request->validate([
            'company_id' => ['required', 'integer', 'exists:companies,id'],
        ]);

        return response()->json([
            'success' => true,
            'data'    => $this->departmentService->statsForCompany((int) $request->input('company_id')),
        ]);
    }

    /**
     * GET /departments/types
     */
    public function types(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => Department::DEPT_TYPES,
        ]);
    }

    /**
     * POST /departments
     */
    public function store(DepartmentRequest $request): JsonResponse
    {
        $department = $this->departmentService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Department created successfully.',
            'data'    => $department->load(['company', 'branch', 'headOffice', 'parent', 'children']),
        ], 201);
    }

    /**
     * GET /departments/{department}
     */
    public function show(Department $department): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $department->load(['company', 'branch', 'headOffice', 'parent', 'children']),
        ]);
    }

    /**
     * PUT|PATCH /departments/{department}
     */
    public function update(DepartmentRequest $request, Department $department): JsonResponse
    {
        $updated = $this->departmentService->update($department, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Department updated successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * DELETE /departments/{department}
     * Soft delete
     */
    public function destroy(Department $department): JsonResponse
    {
        $this->departmentService->delete($department);

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully.',
        ]);
    }

    /**
     * DELETE /departments/{id}/force
     */
    public function forceDestroy(int $id): JsonResponse
    {
        $this->departmentService->forceDelete($id);

        return response()->json([
            'success' => true,
            'message' => 'Department permanently deleted.',
        ]);
    }

    /**
     * POST /departments/{id}/restore
     */
    public function restore(int $id): JsonResponse
    {
        $department = $this->departmentService->restore($id);

        return response()->json([
            'success' => true,
            'message' => 'Department restored successfully.',
            'data'    => $department,
        ]);
    }

    /**
     * PATCH /departments/{department}/toggle-active
     */
    public function toggleActive(Department $department): JsonResponse
    {
        $updated = $this->departmentService->toggleActive($department);

        return response()->json([
            'success' => true,
            'message' => 'Status updated to: ' . $updated->status_label,
            'data'    => $updated,
        ]);
    }

    /**
     * PATCH /departments/{department}/move
     * Body: { "parent_id": 5 }  or  { "parent_id": null }  to make root
     */
    public function move(Request $request, Department $department): JsonResponse
    {
        $request->validate([
            'parent_id' => ['nullable', 'integer', 'exists:departments,id'],
        ]);

        try {
            $updated = $this->departmentService->move($department, $request->input('parent_id'));
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Department moved successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * POST /departments/reorder
     * Body: { "items": [{ "id": 1, "sort_order": 0 }, ...] }
     */
    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items'              => ['required', 'array'],
            'items.*.id'         => ['required', 'integer', 'exists:departments,id'],
            'items.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $this->departmentService->reorder($request->input('items'));

        return response()->json([
            'success' => true,
            'message' => 'Department order updated.',
        ]);
    }

    /**
     * PATCH /departments/{department}/meta
     */
    public function updateMeta(Request $request, Department $department): JsonResponse
    {
        $request->validate([
            'meta'   => ['required', 'array'],
            'meta.*' => ['nullable'],
        ]);

        $updated = $this->departmentService->updateMeta($department, $request->input('meta'));

        return response()->json([
            'success' => true,
            'message' => 'Meta updated successfully.',
            'data'    => $updated,
        ]);
    }
}
