<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubDepartmentRequest;
use App\Services\SubDepartmentService;
use App\Services\DepartmentService;

class SubDepartmentController extends Controller
{
    protected $subDepartmentService;
    protected $departmentService;

    public function __construct(SubDepartmentService $subDepartmentService, DepartmentService $departmentService)
    {
        $this->subDepartmentService = $subDepartmentService;
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $subDepartments = $this->subDepartmentService->getAll();
        $departments = $this->departmentService->getAll();
        return  back()->with('success', 'Sub-department created successfully.');
    }

    public function store(SubDepartmentRequest $request)
    {
        try {
            $this->subDepartmentService->create($request->validated());
            return redirect()->route('master.sub-departments.index')->with('success', 'Sub-department created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $subDepartment = $this->subDepartmentService->getById($id);
        $departments = $this->departmentService->getAll();
        return view('content.master.sub-departments.edit', compact('subDepartment', 'departments'));
    }

    public function update(SubDepartmentRequest $request, $id)
    {
        try {
            $this->subDepartmentService->update($id, $request->validated());
            return back()->with('success', 'Sub-department updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->subDepartmentService->delete($id);
            return back()->with('success', 'Sub-department deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
