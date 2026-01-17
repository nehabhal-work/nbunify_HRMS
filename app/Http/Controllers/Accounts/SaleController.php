<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Models\Sale;
use App\Services\CompanyService;
use App\Services\SaleService;

class SaleController extends Controller
{
    protected $saleService;
    protected $companyService;

    public function __construct(SaleService $saleService, CompanyService $companyService)
    {
        $this->saleService = $saleService;
        $this->companyService = $companyService;
    }

    public function index()
    {
        $sales = Sale::with('customer', 'saleItems')->paginate(15);
        return view('content.accounts.sales.index', compact('sales'));
    }

    public function create()
    {
        return view('content.accounts.sales.create');
    }

    public function store(SaleRequest $request)
    {
        try {
            $this->saleService->createSale($request->validated());
            return redirect()->route('accounts.sales.index')
                ->with('success', 'Sale created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create sale: ' . $e->getMessage());
        }
    }

    public function show(Sale $sale)
    {
        $company = $this->companyService->findFirstOrFail();
        $sale->load('customer', 'saleItems');
        return view('content.accounts.sales.show', compact('sale','company'));
    }

    public function edit(Sale $sale)
    {
        $sale->load('saleItems');
        return view('content.accounts.sales.edit', compact('sale'));
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        try {
            $this->saleService->updateSale($sale, $request->validated());
            return redirect()->route('accounts.sales.index')
                ->with('success', 'Sale updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update sale: ' . $e->getMessage());
        }
    }

    public function destroy(Sale $sale)
    {
        try {
            $sale->delete();
            return redirect()->route('accounts.sales.index')
                ->with('success', 'Sale deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete sale: ' . $e->getMessage());
        }
    }
}
