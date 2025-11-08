<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\DesignationRequest;
use App\Services\DesignationService;

class DesignationController extends Controller
{
    protected $designationService;

    public function __construct(DesignationService $designationService)
    {
        $this->designationService = $designationService;
    }

    public function index()
    {
        $designations = $this->designationService->getAll();
        return view('content.master.designations.index', compact('designations'));
    }

    public function store(DesignationRequest $request)
    {
        try {
            $this->designationService->create($request->validated());
            return redirect()->route('master.designations.index')->with('success', 'Designation created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $designation = $this->designationService->getById($id);
        return view('content.master.designations.edit', compact('designation'));
    }

    public function update(DesignationRequest $request, $id)
    {
        try {
            $this->designationService->update($id, $request->validated());
            return redirect()->route('master.designations.index')->with('success', 'Designation updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->designationService->delete($id);
            return redirect()->route('master.designations.index')->with('success', 'Designation deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}