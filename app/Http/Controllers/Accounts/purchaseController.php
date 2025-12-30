<?php

namespace App\Http\Controllers\Accounts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PurchaseRequest;
use App\Models\Purchase;
use App\Services\PurchaseService;

class PurchaseController extends Controller
{
    protected $purchaseService;

    public function __construct(PurchaseService $purchaseService)
    {
        $this->purchaseService = $purchaseService;
    }

    public function index()
    {
        $purchases = Purchase::with('vendor', 'purchaseItems')->paginate(15);
        return view('content.accounts.purchases.index', compact('purchases'));
    }

    public function create()
    {
        return view('content.accounts.purchases.create');
    }

    public function store(PurchaseRequest $request)
    {
        try {
            $this->purchaseService->createPurchase($request->validated());
            return redirect()->route('accounts.purchases.index')
                ->with('success', 'Purchase created successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create purchase: ' . $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('vendor', 'purchaseItems');
        return view('content.accounts.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $purchase->load('purchaseItems');
        return view('content.accounts.purchases.edit', compact('purchase'));
    }

    public function update(PurchaseRequest $request, Purchase $purchase)
    {
        try {
            $this->purchaseService->updatePurchase($purchase, $request->validated());
            return redirect()->route('accounts.purchases.index')
                ->with('success', 'Purchase updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update purchase: ' . $e->getMessage());
        }
    }

    public function destroy(Purchase $purchase)
    {
        try {
            $purchase->delete();
            return redirect()->route('accounts.purchases.index')
                ->with('success', 'Purchase deleted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete purchase: ' . $e->getMessage());
        }
    }
}
