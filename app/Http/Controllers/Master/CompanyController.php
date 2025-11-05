<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use App\Services\CompanyBankDetailService;

class CompanyController extends Controller
{
     protected $companyService;
    protected $companyBankDetailService;

    public function __construct(CompanyService $companyService, CompanyBankDetailService $companyBankDetailService)
    {
        $this->companyService = $companyService;
        $this->companyBankDetailService = $companyBankDetailService;
    }

    public function index()
    {
        $companies = $this->companyService->getAll();
        return view('content.master.companies.index', compact('companies'));
    }

    public function create() {
        return view('content.master.companies.create');
    }

    public function store(CompanyRequest $request)
    {
        try {
            $company = $this->companyService->create($request->validated());

            if ($request->has('banks')) {
                foreach ($request->banks as $bank) {
                    $this->companyBankDetailService->create($company->id,$bank);
                }
            }
            return redirect()->route('master.companies.index')->with('success', 'Company created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $company = $this->companyService->getById($id);
        $bankDetails = $company->bankDetails ?? collect();
        return view('content.master.companies.edit', compact('company', 'bankDetails'));
    }

    public function update(CompanyRequest $request, $id)
    {
        try {
            $this->companyService->update($id, $request->validated());
            $this->companyBankDetailService->deleteByCompanyId($id);
            if ($request->has('banks')) {
                foreach ($request->banks as $bank) {
                    $this->companyBankDetailService->create($id,$bank);
                }
            }
            return redirect()->route('master.companies.index')->with('success', 'Company updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->companyService->delete($id);
            return redirect()->route('master.companies.index')->with('success', 'Company deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
