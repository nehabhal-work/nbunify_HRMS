<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\InvestmentRequest;
use App\Services\InvestmentService;
use App\Services\SchemeService;

class InvestmentController extends Controller
{
    public function __construct(private InvestmentService $investmentService,
        private SchemeService $schemeService){
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $investments = $this->investmentService->getAll();
        return view('content.investment.index', compact('investments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $scheme = $this->schemeService->getAll();
        return view('content.investment.create', compact('scheme'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InvestmentRequest $request)
    {
        $this->investmentService->create($request->validated());
        return redirect()->route('investment.els.index')->with('success', 'Investment created successfully.');
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
}
