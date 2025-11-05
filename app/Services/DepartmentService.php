<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    public function getAll()
    {
        return Department::with('subDepartments')->get();
    }

    public function getById($id)
    {
        return Department::with('subDepartments')->findOrFail($id);
    }

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function update($id, array $data): Department
    {
        $department = Department::findOrFail($id);
        $department->update($data);
        return $department;
    }

    public function delete($id): bool
    {
        $department = Department::findOrFail($id);
        return $department->delete();
    }
}