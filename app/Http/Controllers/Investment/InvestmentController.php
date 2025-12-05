<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentRequest;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\InvestmentService;
use App\Services\SchemeService;

class InvestmentController extends Controller
{
    public function __construct(
        private InvestmentService $investmentService,
        private SchemeService $schemeService,
        private ClientService $clientService,
        private CompanyService $companyService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return 'inve index';
        $investments = $this->investmentService->getAll();
        return view('content.investment.index', compact('investments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $scheme = $this->schemeService->getAll();
        $clients = $this->clientService->getAllWithFamilyAndBanks();
        $companyBanks = $this->companyService->getFirstCompanyBanks();
        // return $clients;
        return view('content.investment.create', compact('scheme', 'clients', 'companyBanks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvestmentRequest $request)
    {
        $result = $this->investmentService->create($request->validated());
        $client = $this->clientService->find($request->client_id);
        $scheme = $this->schemeService->find($request->scheme_id);
        // return $result;

        // return $scheme;
        return view('content.investment.payout-schedule', compact('result', 'client', 'scheme'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $investment = $this->investmentService->getById($id);
        return view('content.investment.show', compact('investment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $investment = $this->investmentService->getById($id);
        $scheme = $this->schemeService->getAll();
        return view('content.investment.edit', compact('investment', 'scheme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InvestmentRequest $request, string $id)
    {
        $investment = $this->investmentService->getById($id);
        $this->investmentService->update($investment, $request->validated());
        return redirect()->route('investment.els.index')->with('success', 'Investment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $investment = $this->investmentService->getById($id);
        $this->investmentService->delete($investment);
        return redirect()->route('investment.els.index')->with('success', 'Investment deleted successfully.');
    }

    public function renew()
    {
        // $client = $this->clientService->find($id);
        return view('content.investment.renew');
    }
    public function claim()
    {
        return view('content.investment.claim');
    }
    public function merge()
    {
        return view('content.investment.merge');
    }
    public function maturity()
    {
        return view('content.investment.maturity');
    }
}
