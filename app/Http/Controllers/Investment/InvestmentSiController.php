<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentSiRequest;
use App\Services\InvestmentSiService;
use App\Services\InvestmentService;
use App\Services\ClientBankService;
use App\Services\CompanyService;
use Illuminate\Http\Request;

class InvestmentSiController extends Controller
{
    public function __construct(
        private InvestmentSiService $investmentSiService,
        private InvestmentService $investmentService,
        private ClientBankService $clientBankService,
        private CompanyService $companyService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        return $request->all();
        $investments = $this->investmentSiService->getAll();
        $invt = $this->investmentService->getById($request->id);
        return $invt;
        // TODO: Create view - content.investment.si.index
        return view('content.investment.standing-instruction', compact('investments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $investments = $this->investmentService->getAll();
        $companyBanks = $this->companyService->getFirstCompanyBanks();

        return view('content.investment.si.create', compact('investments', 'companyBanks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvestmentSiRequest $request)
    {
        $this->investmentSiService->create($request->validated());
        return redirect()->route('investment.si.index')->with('success', 'Standing Instruction created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $investmentSi = $this->investmentSiService->getById($id);
        $investments = $this->investmentService->getAll();
        $companyBanks = $this->companyService->getFirstCompanyBanks();

        return view('content.investment.si.edit', compact('investmentSi', 'investments', 'companyBanks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvestmentSiRequest $request, string $id)
    {
        $investmentSi = $this->investmentSiService->getById($id);
        $this->investmentSiService->update($investmentSi, $request->validated());
        return redirect()->route('investment.si.index')->with('success', 'Standing Instruction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $investmentSi = $this->investmentSiService->getById($id);
        $this->investmentSiService->delete($investmentSi);
        return redirect()->route('investment.si.index')->with('success', 'Standing Instruction deleted successfully.');
    }
}
