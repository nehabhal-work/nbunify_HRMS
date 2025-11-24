<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeeBankDetail;
use Illuminate\Support\Str;

class EmployeeService
{
    public function __construct(private FileStorageService $fileStorageService)
    {
    }

    public function getAll()
    {
        return Employee::with(['branch', 'department', 'designation', 'manager'])->get();
    }

    public function find($id)
    {
        return Employee::with(['branch', 'department', 'designation', 'manager', 'bankDetails'])->findOrFail($id);
    }

    public function create(array $data): Employee
    {
        $bankData = $data['banks'] ?? [];
        unset($data['banks']);

        $employee = Employee::create($data);
        $data = $this->handleFileUploads($data, $employee, 'A');
        $employee->update($data);

        if (!empty($bankData)) {
            $this->handleBankDetails($employee, $bankData);
        }

        return $employee->fresh();
    }

    public function update(Employee $employee, array $data): Employee
    {
        $bankData = $data['banks'] ?? [];
        unset($data['banks']);

        $data = $this->handleFileUploads($data, $employee, 'E');
        $employee->update($data);

        if (!empty($bankData)) {
            $employee->bankDetails()->delete();
            $this->handleBankDetails($employee, $bankData);
        }

        return $employee->fresh();
    }

    public function delete(Employee $employee): bool
    {
        $this->deleteFiles($employee);
        $employee->bankDetails()->delete();
        return $employee->delete();
    }

    private function handleFileUploads(array $data, Employee $employee, string $mode): array
    {
        $fileFields = [
            'attachement_employee_photo',
            'attachement_aadhar',
            'attachment_release_letter',
            'attachment_expereance',
            'attachment_pan',
            'attachment_cv'
        ];

        if ($mode == 'A') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    $data[$field] = $this->fileStorageService->storeEmployeeDocument(
                        $employee->id,
                        $data[$field . '_url'],
                        str_replace(['attachement_', 'attachment_'], '', $field)
                    );
                }
            }
        } else if ($mode == 'E') {
            foreach ($fileFields as $field) {
                if (isset($data[$field . '_url'])) {
                    if (Str::contains($data[$field . '_url'], 'temp')) {
                        if ($employee && $employee->$field) {
                            $this->fileStorageService->deleteFile($employee->$field);
                        }
                        $data[$field] = $this->fileStorageService->storeEmployeeDocument(
                            $employee->id,
                            $data[$field . '_url'],
                            str_replace(['attachement_', 'attachment_'], '', $field)
                        );
                    } else {
                        $data[$field] = $employee->$field ?? null;
                    }
                } else {
                    if ($employee && $employee->$field) {
                        $this->fileStorageService->deleteFile($employee->$field);
                    }
                    $data[$field] = null;
                }
            }
        }
        return $data;
    }

    private function deleteFiles(Employee $employee): void
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
                $this->fileStorageService->deleteFile($employee->$field);
            }
        }
    }

    private function handleBankDetails(Employee $employee, array $bankData): void
    {
        foreach ($bankData as $index => $bank) {
            if (!empty($bank['ifsc_code']) && !empty($bank['account_number'])) {
                EmployeeBankDetail::create([
                    'employee_id' => $employee->id,
                    'ifsc_code' => $bank['ifsc_code'],
                    'account_number' => $bank['account_number'],
                    'bank_name' => $bank['bank_name'] ?? null,
                    'branch_name' => $bank['branch_name'] ?? null,
                    'bank_code' => $bank['bank_code'] ?? null,
                    'account_type' => $bank['account_type'] ?? null,
                    'is_primary' => $bank['is_primary'] ?? ($index === 0),
                ]);
            }
        }
    }
}