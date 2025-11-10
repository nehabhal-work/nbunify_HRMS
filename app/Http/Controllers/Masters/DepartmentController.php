<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentRequest;
use App\Services\DepartmentService;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    public function index()
    {
        $departments = $this->departmentService->getAll();
        return view('content.master.departments.index', compact('departments'));
    }

    public function store(DepartmentRequest $request)
    {
        try {
            $this->departmentService->create($request->validated());
            return redirect()->route('master.departments.index')->with('success', 'Department created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $department = $this->departmentService->getById($id);
        return view('content.master.departments.edit', compact('department'));
    }

    public function update(DepartmentRequest $request, $id)
    {
        try {
            $this->departmentService->update($id, $request->validated());
            return redirect()->route('master.departments.index')->with('success', 'Department updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $this->departmentService->delete($id);
            return redirect()->route('master.departments.index')->with('success', 'Department deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}