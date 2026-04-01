<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\HeadOfficeRequest;
use App\Models\HeadOffice;
use Illuminate\Http\Request;
use App\Services\HeadOfficeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class HeadOfficeController extends Controller
{
    public function __construct(protected HeadOfficeService $headOfficeService)
    {
    }

    /**
     * GET /head-offices
     * Supports: ?company_id=1 &search=mumbai &is_active=1 &per_page=15
     */
    public function index(Request $request)
    {
        $filters = $request->only(['company_id', 'search', 'is_active']);
        $perPage = $request->integer('per_page', 15);

        $headOffices = $this->headOfficeService->paginate($filters, $perPage);

        return view('content.master.head-office.index', compact('headOffices'));


    }

    /**
     * POST /head-offices
     */
    public function store(HeadOfficeRequest $request)
    {
        $headOffice = $this->headOfficeService->create($request->validated());


    }

    /**
     * GET /head-offices/{head_office}
     */
    public function show(HeadOffice $headOffice)
    {
        return view('content.master.head-office.view');

    }

    /**
     * PUT|PATCH /head-offices/{head_office}
     */
    public function update(HeadOfficeRequest $request, HeadOffice $headOffice)
    {
        $updated = $this->headOfficeService->update($headOffice, $request->validated());


    }

    /**
     * DELETE /head-offices/{head_office}
     * Soft delete
     */
    public function destroy(HeadOffice $headOffice)
    {
        $this->headOfficeService->delete($headOffice);

        return response()->json([
            'success' => true,
            'message' => 'Head office deleted successfully.',
        ]);
    }

    /**
     * DELETE /head-offices/{id}/force
     * Permanent delete
     */
    public function forceDestroy(int $id)
    {
        $this->headOfficeService->forceDelete($id);

        return response()->json([
            'success' => true,
            'message' => 'Head office permanently deleted.',
        ]);
    }

    /**
     * POST /head-offices/{id}/restore
     */
    public function restore(int $id)
    {
        $headOffice = $this->headOfficeService->restore($id);

        return response()->json([
            'success' => true,
            'message' => 'Head office restored successfully.',
            'data' => $headOffice,
        ]);
    }

    /**
     * PATCH /head-offices/{head_office}/toggle-active
     */
    public function toggleActive(HeadOffice $headOffice)
    {
        $updated = $this->headOfficeService->toggleActive($headOffice);

        return response()->json([
            'success' => true,
            'message' => 'Status updated to: ' . $updated->status_label,
            'data' => $updated,
        ]);
    }

    /**
     * PATCH /head-offices/{head_office}/meta
     * Merge-update the meta JSON field
     */
    public function updateMeta(Request $request, HeadOffice $headOffice)
    {
        $request->validate([
            'meta' => ['required', 'array'],
            'meta.*' => ['nullable'],
        ]);

        $updated = $this->headOfficeService->updateMeta($headOffice, $request->input('meta'));

        return response()->json([
            'success' => true,
            'message' => 'Meta updated successfully.',
            'data' => $updated,
        ]);
    }
}
