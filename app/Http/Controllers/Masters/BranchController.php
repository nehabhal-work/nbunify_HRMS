<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\BranchRequest;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function __construct(protected BranchService $branchService) {}

    /**
     * GET /branches
     * Filters: ?company_id= &head_office_id= &branch_type= &status= &search= &per_page=
     */
    public function index(Request $request)
    {
        $filters = $request->only(['company_id', 'head_office_id', 'branch_type', 'status', 'search']);
        $perPage = $request->integer('per_page', 15);

        $branches = $this->branchService->paginate($filters, $perPage);

              return view('content.master.branches.index', compact('branches'));

    }

    /**
     * POST /branches
     */
    public function store(BranchRequest $request)
    {
        $branch = $this->branchService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Branch created successfully.',
            'data'    => $branch->load(['company', 'headOffice', 'createdBy', 'updatedBy']),
        ], 201);
    }

    /**
     * GET /branches/{branch}
     */
    public function show(Branch $branch)
    {
        return response()->json([
            'success' => true,
            'data'    => $branch->load(['company', 'headOffice', 'createdBy', 'updatedBy']),
        ]);
    }

    /**
     * PUT|PATCH /branches/{branch}
     */
    public function update(BranchRequest $request, Branch $branch)
    {
        $updated = $this->branchService->update($branch, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Branch updated successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * DELETE /branches/{branch}
     * Soft delete
     */
    public function destroy(Branch $branch)
    {
        $this->branchService->delete($branch);

        return response()->json([
            'success' => true,
            'message' => 'Branch deleted successfully.',
        ]);
    }

    /**
     * DELETE /branches/{id}/force
     * Permanent delete
     */
    public function forceDestroy(int $id)
    {
        $this->branchService->forceDelete($id);

        return response()->json([
            'success' => true,
            'message' => 'Branch permanently deleted.',
        ]);
    }

    /**
     * POST /branches/{id}/restore
     */
    public function restore(int $id)
    {
        $branch = $this->branchService->restore($id);

        return response()->json([
            'success' => true,
            'message' => 'Branch restored successfully.',
            'data'    => $branch,
        ]);
    }

    /**
     * PATCH /branches/{branch}/status
     * Body: { "status": "active|inactive|closed" }
     */
    public function changeStatus(Request $request, Branch $branch)
    {
        $request->validate([
            'status' => ['required', 'in:active,inactive,closed'],
        ]);

        $updated = $this->branchService->changeStatus($branch, $request->input('status'));

        return response()->json([
            'success' => true,
            'message' => "Branch status changed to: {$updated->status_label}",
            'data'    => $updated,
        ]);
    }

    /**
     * POST /branches/reorder
     * Body: { "items": [{ "id": 1, "sort_order": 0 }, ...] }
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'items'              => ['required', 'array'],
            'items.*.id'         => ['required', 'integer', 'exists:branches,id'],
            'items.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $this->branchService->reorder($request->input('items'));

        return response()->json([
            'success' => true,
            'message' => 'Branch order updated successfully.',
        ]);
    }

    /**
     * PATCH /branches/{branch}/opening-hours
     * Body: { "opening_hours": { "mon": { "open": "09:00", "close": "18:00" } } }
     */
    public function updateOpeningHours(Request $request, Branch $branch)
    {
        $request->validate([
            'opening_hours'              => ['required', 'array'],
            'opening_hours.*.open'       => ['nullable', 'date_format:H:i'],
            'opening_hours.*.close'      => ['nullable', 'date_format:H:i'],
            'opening_hours.*.is_holiday' => ['nullable', 'boolean'],
        ]);

        $updated = $this->branchService->updateOpeningHours($branch, $request->input('opening_hours'));

        return response()->json([
            'success' => true,
            'message' => 'Opening hours updated successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * PATCH /branches/{branch}/meta
     * Merge-update meta JSON field
     */
    public function updateMeta(Request $request, Branch $branch)
    {
        $request->validate([
            'meta'   => ['required', 'array'],
            'meta.*' => ['nullable'],
        ]);

        $updated = $this->branchService->updateMeta($branch, $request->input('meta'));

        return response()->json([
            'success' => true,
            'message' => 'Meta updated successfully.',
            'data'    => $updated,
        ]);
    }

    /**
     * GET /branches/stats?company_id=1
     */
    public function stats(Request $request)
    {
        $request->validate([
            'company_id' => ['required', 'integer', 'exists:companies,id'],
        ]);

        $stats = $this->branchService->statsForCompany((int) $request->input('company_id'));

        return response()->json([
            'success' => true,
            'data'    => $stats,
        ]);
    }

    /**
     * GET /branches/types
     */
    public function types()
    {
        return response()->json([
            'success' => true,
            'data'    => Branch::BRANCH_TYPES,
        ]);
    }

    /**
     * GET /branches/statuses
     */
    public function statuses()
    {
        return response()->json([
            'success' => true,
            'data'    => Branch::STATUSES,
        ]);
    }
}
