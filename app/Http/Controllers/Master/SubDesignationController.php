<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubDesignationRequest;
use App\Services\SubDesignationService;
use App\Services\DesignationService;

class SubDesignationController extends Controller
{
    protected $subDesignationService;
    protected $designationService;

    public function __construct(SubDesignationService $subDesignationService, DesignationService $designationService)
    {
        $this->subDesignationService = $subDesignationService;
        $this->designationService = $designationService;
    }

    public function index()
    {
        $subDesignations = $this->subDesignationService->getAll();
        $designations = $this->designationService->getAll();
        return back()->with('success', 'Sub-designations retrieved successfully.');
    }

    public function store(SubDesignationRequest $request)
    {
        try {
            $this->subDesignationService->create($request->validated());
            return back()->with('success', 'Sub-designation created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $subDesignation = $this->subDesignationService->getById($id);
        $designations = $this->designationService->getAll();
        return view('content.master.sub-designations.edit', compact('subDesignation', 'designations'));
    }

    public function update(SubDesignationRequest $request, $id)
    {
        try {
            $this->subDesignationService->update($id, $request->validated());
            return redirect()->route('master.sub-designations.index')->with('success', 'Sub-designation updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->subDesignationService->delete($id);
            return back() > with('success', 'Sub-designation deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
