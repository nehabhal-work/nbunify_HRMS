<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $companyService) {}

    public function index(): View
    {
        return view('content.master.companies.index', [
            'companies' => Company::all()
        ]);
    }

    public function create(): View
    {
        return view('content.master.companies.create');
    }

    public function store(CompanyRequest $request): RedirectResponse
    {
        $this->companyService->create($request->validated());
        return redirect()->route('master.companies.index');
    }

    // public function show(Company $company): View
    // {
    //     return view('content.master.companies.show', [
    //         'company' => $company
    //     ]);
    // }

    public function edit(Company $company): View
    {
        return view('content.master.companies.edit', [
            'company' => $company
        ]);
    }

    public function update(CompanyRequest $request, Company $company): RedirectResponse
    {
        $this->companyService->update($company, $request->validated());
        return redirect()->route('master.companies.index');
    }

    public function destroy(Company $company): RedirectResponse
    {
        $this->companyService->delete($company);
        return redirect()->route('master.companies.index');
    }
}
