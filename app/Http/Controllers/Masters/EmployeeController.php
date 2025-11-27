<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Services\BranchService;
use App\Services\CompanyService;
use App\Services\DepartmentService;
use App\Services\DesignationService;
use App\Services\EmployeeService;
use App\Services\FileStorageService;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function __construct(
        private EmployeeService $employeeService,
        private FileStorageService $fileStorageService,
        private BranchService $branchService,
        private DepartmentService $departmentService,
        private DesignationService $designationService,
        private CompanyService $CompanyService,
    ) {}

    public function index()
    {
        $employees = $this->employeeService->getAll();
        return view('content.master.employees.index', compact('employees'));
    }

    public function create()
    {
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];
        $branches = $this->branchService->getAll();
        $departments = $this->departmentService->getAll();
        $designations = $this->designationService->getAll();
        return view('content.master.employees.create', compact('country', 'states', 'cities', 'branches', 'departments', 'designations'));
    }

    public function store(EmployeeRequest $request)
    {
        $employee = null;
        DB::transaction(function () use ($request, &$employee) {
            $employee = $this->employeeService->create($request->validated());
        });

        return redirect()->route('master.employees.index')->with('success', 'Employee created successfully');
    }
    public function edit($id)
    {
        $employee = $this->employeeService->find($id);
        $employee = $this->addFileUrls($employee);

        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];

        $branches = $this->branchService->getAll();
        $departments = $this->departmentService->getAll();
        $designations = $this->designationService->getAll();

        return view('content.master.employees.edit', compact('employee', 'country', 'states', 'cities', 'branches', 'departments', 'designations'));
    }

    public function update(EmployeeRequest $request, $id)
    {
        $employee = $this->employeeService->find($id);
        DB::transaction(function () use ($request, $employee) {
            $this->employeeService->update($employee, $request->validated());
        });

        return redirect()->route('master.employees.index')->with('success', 'Employee updated successfully');
    }

    public function destroy($id)
    {
        $employee = $this->employeeService->find($id);
        $this->employeeService->delete($employee);
        return redirect()->route('master.employees.index')->with('success', 'Employee deleted successfully');
    }

    private function addFileUrls($employee)
    {
        $fileFields = [
            'attachement_employee_photo',
            'attachement_aadhar',
            'attachment_release_letter',
            'attachment_expereance',
            'attachment_pan',
            'attachment_cv'
        ];

        foreach ($fileFields as $field) {
            if ($employee->$field) {
                $employee->{$field . '_url'} = $this->fileStorageService->getTemporaryUrl($employee->$field);
            }
        }

        return $employee;
    }


    public function hrLetter($type, $id)
    {
        $employee = $this->employeeService->find($id);
        $company = $this->CompanyService->find($employee->company_id);


        // allowed types for safety
        $validTypes = [
            'appointment',
            'confirmation',
            'experience',
            'offer',
            'relieving',
            'salary-increment'
        ];

        // if invalid type – show 404
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        // dynamic view path 
        $view = "content.master.employees.hr-letter.$type";

        return view($view, compact('employee', 'company'));
    }
}
