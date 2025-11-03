<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Models\Branch;
use App\Services\BranchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class BranchController extends Controller
{
    public function __construct(private BranchService $branchService) {}

    public function index(): View
    {
        return view('content.master.branches.index', [
            'branches' => Branch::all()
        ]);
    }

    public function create(): View
    {
        return view('content.master.branches.create');
    }

    public function store(StoreBranchRequest $request): RedirectResponse
    {
        $this->branchService->createBranch($request->validated());
        return redirect()->route('master.branches.index')->with('success', 'Branch created successfully.');
    }

    public function edit(Branch $branch): View
    {
        return view('content.master.branches.edit', [
            'branch' => $branch
        ]);
    }

    public function update(StoreBranchRequest $request, Branch $branch): RedirectResponse
    {
        $this->branchService->updateBranch($branch->id, $request->validated());
        return redirect()->route('master.branches.edit', $branch->id)->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        $this->branchService->deleteBranch($branch->id);
        return redirect()->route('master.branches.index')->with('success', 'Branch deleted successfully.');
    }
}
