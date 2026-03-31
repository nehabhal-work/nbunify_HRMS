<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $companyService) {}

    /**
     * GET /companies
     * List with optional search & filter
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'company_type']);
        $perPage = $request->integer('per_page', 15);

        $companies = $this->companyService->paginate($filters, $perPage);

        return response()->json([
            'success' => true,
            'data'    => $companies,
        ]);
    }

    /**
     * POST /companies
     * Create a new company
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        $company = $this->companyService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Company created successfully.',
            'data'    => $company->load(['createdBy', 'updatedBy']),
        ], 201);
    }

    /**
     * GET /companies/{company}
     * Show a single company
     */
    public function show(Company $company): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $company->load(['createdBy', 'updatedBy']),
        ]);
    }

    /**
     * PUT/PATCH /companies/{company}
     * Update a company
     */
    public function update(CompanyRequest $request, Company $company): JsonResponse
    {
        $updated = $this->companyService->update($company, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Company updated successfully.',
            'data'    => $updated->load(['createdBy', 'updatedBy']),
        ]);
    }

    /**
     * DELETE /companies/{company}
     * Soft delete a company
     */
    public function destroy(Company $company): JsonResponse
    {
        $this->companyService->delete($company);

        return response()->json([
            'success' => true,
            'message' => 'Company deleted successfully.',
        ]);
    }

    /**
     * DELETE /companies/{id}/force
     * Permanently delete a company and its files
     */
    public function forceDestroy(int $id): JsonResponse
    {
        $company = Company::withTrashed()->findOrFail($id);
        $this->companyService->forceDelete($company);

        return response()->json([
            'success' => true,
            'message' => 'Company permanently deleted.',
        ]);
    }

    /**
     * POST /companies/{id}/restore
     * Restore a soft-deleted company
     */
    public function restore(int $id): JsonResponse
    {
        $company = $this->companyService->restore($id);

        return response()->json([
            'success' => true,
            'message' => 'Company restored successfully.',
            'data'    => $company,
        ]);
    }

    /**
     * DELETE /companies/{company}/files/{field}
     * Remove a specific attachment
     */
    public function deleteFile(Company $company, string $field): JsonResponse
    {
        $deleted = $this->companyService->deleteFile($company, $field);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid file field specified.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'File removed successfully.',
        ]);
    }

    /**
     * GET /companies/types
     * Return available company types
     */
    public function types(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => Company::COMPANY_TYPES,
        ]);
    }
}
