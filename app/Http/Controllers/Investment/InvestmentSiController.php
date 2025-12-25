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
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // return $request->all();
        // $si = $this->investmentSiService->getAll();
        $investment = $this->investmentService->getById($request->id);

        // return $investment;
        // TODO: Create view - content.investment.si.index
        return view('content.investment.standing-instruction.index', compact('investment'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $investments = $this->investmentService->getAll();
        // $companyBanks = $this->companyService->getFirstCompanyBanks();

        // return view('content.investment.si.create', compact('investments', 'companyBanks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvestmentSiRequest $request)
    {
        // return $request;
        $this->investmentSiService->create($request->validated());
        return redirect()->route('investment.si.index', ['id' => $request->investment_id])->with('success', 'Standing Instruction created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(string $id)
{
    // Standing Instruction
    $investmentSi = $this->investmentSiService->getById($id);

    // Parent Investment (REQUIRED)
    $investment = $this->investmentService->getById(
        $investmentSi->investment_id
    );

    // Optional data (if you still need them)
    $investments = $this->investmentService->getAll();
    $companyBanks = $this->companyService->getFirstCompanyBanks();

    return view(
        'content.investment.standing-instruction.edit',
        compact(
            'investmentSi',
            'investment',
            'investments',
            'companyBanks'
        )
    );
}


    /**
     * Update the specified resource in storage.
     */
    // public function update(InvestmentSiRequest $request, string $id)
    // {
    //     $investmentSi = $this->investmentSiService->getById($id);
    //     $this->investmentSiService->update($investmentSi, $request->validated());
    //     return redirect()->route('investment.si.index')->with('success', 'Standing Instruction updated successfully.');
    // }
    public function update(InvestmentSiRequest $request, string $id)
    {
        $investmentSi = $this->investmentSiService->getById($id);

        $this->investmentSiService->update(
            $investmentSi,
            $request->validated()
        );

        return redirect()
            ->route('investment.si.index', ['id' => $investmentSi->investment_id])
            ->with('success', 'Standing Instruction updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // return $id;
        $investmentSi = $this->investmentSiService->getById($id);
        $this->investmentSiService->delete($investmentSi);
        return redirect()->route('investment.si.index')->with('success', 'Standing Instruction deleted successfully.');
    }


}
