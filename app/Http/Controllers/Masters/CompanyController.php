<?php

namespace App\Http\Controllers\Masters;

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

    public function create()
    {
        $companyTypes = config('enum_company_types');
        $bankAccountTypes = config('enum_bank_account_types');
        return view('content.master.companies.create', compact('companyTypes', 'bankAccountTypes'));
    }

    public function store(CompanyRequest $request)
    {
        try {
            $company = $this->companyService->create($request->validated());

            if ($request->has('banks')) {
                foreach ($request->banks as $bank) {
                    $this->companyBankDetailService->create($company->id, $bank);
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
        $companyTypes = config('enum_company_types');
        $bankAccountTypes = config('enum_bank_account_types');
        return view('content.master.companies.edit', compact('company', 'bankDetails','companyTypes','bankAccountTypes'));
    }

    public function update(CompanyRequest $request, $id)
    {
        try {
            $company = $this->companyService->getById($id);
            $this->companyService->update($company, $request->validated());
            $this->companyBankDetailService->deleteByCompanyId($id);
            if ($request->has('banks')) {
                foreach ($request->banks as $bank) {
                    $this->companyBankDetailService->create($id, $bank);
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
            $company = $this->companyService->getById($id);
            $this->companyService->delete($company);
            return redirect()->route('master.companies.index')->with('success', 'Company deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
