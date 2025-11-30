<?php

namespace App\Http\Controllers\Investment;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchemesMasterRequest;
use App\Services\SchemeService;
use Illuminate\Http\Request;

class SchemeController extends Controller
{
    public function __construct(
        private SchemeService $schemeService
    ) {}

    public function index()
    {
        $schemes = $this->schemeService->getAll();
        return view('content.investment.scheme.index', compact('schemes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SchemesMasterRequest $request)
    {
        $this->schemeService->create($request->validated());
        return redirect()->route('investment.scheme.index')->with('success', 'Scheme created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $scheme = $this->schemeService->find($id);
        return view('content.investment.scheme.view', compact('scheme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $scheme = $this->schemeService->find($id);
        return view('content.investment.scheme.edit', compact('scheme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SchemesMasterRequest $request, $id)
    {
        $scheme = $this->schemeService->find($id);
        $this->schemeService->update($scheme, $request->validated());
        return redirect()->route('investment.scheme.edit', $id)->with('success', 'Scheme updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $scheme = $this->schemeService->find($id);
        $this->schemeService->delete($scheme);
        return redirect()->route('investment.scheme.index')->with('success', 'Scheme deleted successfully.');
    }
}
