<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class CompanyController extends Controller
{
    public function __construct(protected CompanyService $companyService) {}

    /**
     * GET /companies
     * List with optional search & filter
     */
    public function index(Request $request)
    {

        $companies = $this->companyService->getAll();

        return view('content.master.companies.index', compact('companies'));
        // return response()->json([
        //     'success' => true,
        //     'data'    => $companies,
        // ]);
    }

    /**
     * POST /companies
     * Create a new company
     */
    public function create()
    {
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        $companyTypes = Company::COMPANY_TYPES;
        return view('content.master.companies.create', compact('country', 'states', 'cities', 'companyTypes'));
    }

    // public function store(Request $request)
    public function store(CompanyRequest $request)
    {
        // return 'company store';

        // $request = [
        //     // Basic Info
        //     'name'          => 'Acme Technologies',
        //     'legal_name'    => 'Acme Technologies Private Limited',
        //     'company_type'  => 'pvt_ltd',
        //     'website'       => 'https://acme.example.com',
        //     'logo'          => null,

        //     // Registration Numbers
        //     'watermark_no'                => 'WM-2024-001',
        //     'copyrights_no'               => 'CR-2024-001',
        //     'cin_no'                      => 'U74999MH2020PTC123456',
        //     'pan_no'                      => 'AABCA1234C',
        //     'tan_no'                      => 'MUMA12345B',
        //     'gstin'                       => '27AABCA1234C1Z5',
        //     'udyam_aadhar_no'             => 'UDYAM-MH-01-0001234',
        //     'partnership_registration_no' => '1231',
        //     'roc_no'                      => 'ROC-MUMBAI-123456',
        //     'msme_certification_no'       => 'MSME-MH-2024-001',
        //     'ckyc'                        => '12345678901234',
        //     'gumasta_no'                  => 'GM-MUM-2024-001',

        //     // Establishment Date
        //     'est_date' => '2020-06-15',

        //     // No file attachments in dummy test
        //     'attachment_pan'              => null,
        //     'attachment_tan'              => null,
        //     'attachment_gstin'            => null,
        //     'attachment_ckyc'             => null,
        //     'attachment_partnership_deed' => null,
        //     'attachment_udyam_aadhar'     => null,
        //     'attachment_gumasta'          => null,
        //     'attachment_msme'             => null,

        //     // Audit (use user ID 1 for testing)
        //     'created_by' => 1,
        //     'updated_by' => 1,
        // ];

        // return $request;

        // $company = $this->companyService->create($request);
        $company = $this->companyService->create($request->validated());

        return redirect()->route('master.companies.index')->with('success', 'Company created successfully.');

        // return response()->json([
        //     'success' => true,
        //     'message' => 'Company created successfully.',
        //     'data'    => $company->load(['createdBy', 'updatedBy']),
        // ], 201);
    }

    /**
     * GET /companies/{company}
     * Show a single company
     */
    public function show(Company $company)
    {
        $company = $company->load(['createdBy', 'updatedBy']);
        return view('content.master.companies.view', compact('company'));
    }

    public function edit(Company $company)
    {
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        $companyTypes = Company::COMPANY_TYPES;

        $bankDetails = $company->bankDetails ?? [];
        return view('content.master.companies.edit', compact('company', 'country', 'states', 'cities', 'companyTypes', 'bankDetails'));
    }
    /**
     * PUT/PATCH /companies/{company}
     * Update a company
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $updated = $this->companyService->update($company, $request->validated());
        return redirect()->route('master.companies.index')
            ->with('success', 'Company updated successfully.');
    }

    /**
     * DELETE /companies/{company}
     * Soft delete a company
     */
    public function destroy($id)
    {
        $company = Company::destroy($id);

        return view('content.master.companies.index')->with('success', 'Company deleted successfully.');
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
            'data' => $company,
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
            'data' => Company::COMPANY_TYPES,
        ]);
    }
}
