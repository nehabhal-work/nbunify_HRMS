<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchemesMasterRequest;
use App\Models\SchemesMaster;
use App\Services\SchemeService;
use Illuminate\Http\Request;

class SchemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected SchemeService $schemeService;
    public function __construct(SchemeService $schemeService)
    {
        $this->schemeService = $schemeService;
    }

    public function index()
    {

        return view('content.investment.scheme.index', ['schemes' => SchemesMaster::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchemesMasterRequest $request)
    {
        $data = $request->validated();

        // frequency is array → will auto-cast to JSON
        $this->schemeService->createScheme($data);

        return redirect()
            ->route('investment.scheme.index')
            ->with('success', 'Scheme created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $scheme = $this->schemeService->find($id);
        return view('content.investment.scheme.edit', compact('scheme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $scheme = $this->schemeService->find($id);
        $data = $request->all();
        $this->schemeService->updateScheme($scheme, $data);

        return redirect()
            ->route('investment.scheme.edit', $scheme->id)
            ->with('success', 'Scheme updated successfully.');
    }

    // public function update(StoreBranchRequest $request, $id): RedirectResponse
    // {
    //     $branch = $this->branchService->find($id);
    //     $this->branchService->updateBranch($branch->id, $request->validated());
    //     return redirect()->route('master.branches.edit', $branch->id)->with('success', 'Branch updated successfully.');
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $scheme = $this->schemeService->find($id);
        $this->schemeService->deleteScheme($scheme->id);
        return redirect()->route('investment.scheme.index')->with('success', 'Scheme deleted successfully.');
    }
}
