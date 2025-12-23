<?php

namespace App\Http\Controllers\Masters;

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
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        
        return view('content.master.branches.index', [
            'branches' => Branch::all()
        ], compact('country', 'states', 'cities'));
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

    public function edit($id): View
    {
        $branch = $this->branchService->find($id);
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];

        return view('content.master.branches.edit', [
            'branch' => $branch
        ], compact('country', 'states', 'cities'));
    }

    public function update(StoreBranchRequest $request, $id): RedirectResponse
    {
        $branch = $this->branchService->find($id);
        $this->branchService->updateBranch($branch->id, $request->validated());
        return redirect()->route('master.branches.edit', $branch->id)->with('success', 'Branch updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $branch = $this->branchService->find($id);
        $this->branchService->deleteBranch($branch->id);
        return redirect()->route('master.branches.index')->with('success', 'Branch deleted successfully.');
    }
}
