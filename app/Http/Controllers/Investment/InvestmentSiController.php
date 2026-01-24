<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentSiRequest;
use App\Services\ClientBankService;
use App\Services\CompanyService;
use App\Services\InvestmentService;
use App\Services\InvestmentSiService;
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
    // public function store(Request $request)
    public function store(InvestmentSiRequest $request)
    {
        // return $request;
        try {
            $data = $request->validated();
            $data['created_by'] = auth()->id();
            $this->investmentSiService->create($data);

            return redirect()->route('investment.si.index', ['id' => $request->investment_id])->with('success', 'Standing Instruction created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
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

    public function show(string $id)
    {
        // Standing Instruction
        $investmentSi = $this->investmentSiService->showById($id);
// return $investmentSi;
        // Parent Investment (REQUIRED)
        $investment = $this->investmentService->getById(
            $investmentSi->investment_id
        );

        // Optional data (if you still need them)
        $investments = $this->investmentService->getAll();
        $companyBanks = $this->companyService->getFirstCompanyBanks();

        return view(
            'content.investment.standing-instruction.view',
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
        try {
            $investmentSi = $this->investmentSiService->getById($id);

            $this->investmentSiService->update(
                $investmentSi,
                $request->validated()
            );

            return redirect()
                ->route('investment.si.index', ['id' => $investmentSi->investment_id])
                ->with('success', 'Standing Instruction updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($si)
    {
        $investmentSi = $this->investmentSiService->getById($si);
        $this->investmentSiService->delete($investmentSi);

        return redirect()->route('investment.si.index', ['id' => $investmentSi->investment_id])->with('success', 'Standing Instruction deleted successfully.');
    }

    /**
     * Approve the specified resource.
     */
    public function approve($id)
    {
        try {
            $this->investmentSiService->approve($id);

            return redirect()->route('investment.si.index', ['id' => $this->investmentSiService->getById($id)->investment_id])->with('success', 'Standing Instruction approved successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
