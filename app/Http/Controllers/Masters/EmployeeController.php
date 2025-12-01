<?php

namespace App\Http\Controllers\Masters;

use PDF;
use App\Services\BranchService;
use App\Services\CompanyService;
use App\Services\EmployeeService;
use Illuminate\Support\Facades\DB;
use App\Services\DepartmentService;
use App\Http\Controllers\Controller;
use App\Services\DesignationService;
use App\Services\FileStorageService;
use App\Http\Requests\EmployeeRequest;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;
use Dompdf\Adapter\PDFLib;

class EmployeeController extends Controller
{
    public function __construct(
        private EmployeeService $employeeService,
        private FileStorageService $fileStorageService,
        private BranchService $branchService,
        private DepartmentService $departmentService,
        private DesignationService $designationService,
        private CompanyService $CompanyService,
    ) {
    }

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
    public function show($id)
    {
        // fetch employee
        $employee = $this->employeeService->find($id);
        $employee = $this->addFileUrls($employee);

        // fetch location data
        $data = getCountries();
        $country = $data['country'] ?? null;
        $states = $data['states'] ?? [];
        $cities = $data['cities'] ?? [];

        // fetch master data
        $branches = $this->branchService->getAll();
        $departments = $this->departmentService->getAll();
        $designations = $this->designationService->getAll();

        // return show view
        return view(
            'content.master.employees.view',
            compact('employee', 'country', 'states', 'cities', 'branches', 'departments', 'designations')
        );
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
        // return  $id;

        $employee = $this->employeeService->find($id);
        // $company = $this->CompanyService->find($employee->company_id); #tanmay need company id in employee table
        // return $employee;
        $company = $this->CompanyService->find(1);
        $type = strtolower($type);

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
        $view = "content.master.employees.hr-letter." . $type;

        return view('content.master.employees.hr-letter.appointment', compact('employee', 'company', 'type'));
    }



    public function hrLetterPdf($type, $id)
    {
        $employee = $this->employeeService->find($id);

        $validTypes = [
            'appointment',
            'confirmation',
            'experience',
            'offer',
            'relieving',
            'salary-increment'
        ];

        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $pdf = PDF::loadView("content.master.employees.hr-letter." . $type . "-pdf", [
            'employee' => $employee,
            'type' => $type
        ])->setPaper('A4', 'portrait');

        // Open in browser
        return $pdf->stream("{$type}_letter_{$employee->id}.pdf");

        // Or force download
        // return $pdf->download("{$type}_letter_{$employee->id}.pdf");
    }




    public function hrLetterEmail($type, $id)
    {
        $employee = $this->employeeService->find($id);

        // $pdf = \PDF::loadView("content.master.employees.hr-letter.$type", [
        //     'employee' => $employee,
        //     'type' => $type
        // ])->output();

        // \Mail::send([], [], function ($message) use ($employee, $type, $pdf) {
        //     $message->to($employee->email)
        //         ->subject(ucfirst($type) . " Letter")
        //         ->attachData($pdf, "{$type}_letter.pdf", [
        //             'mime' => 'application/pdf',
        //         ])
        //         ->setBody("Dear {$employee->name},<br>Your {$type} letter is attached.", 'text/html');
        // });

        return back()->with('success', 'Email sent successfully.');
    }
}
