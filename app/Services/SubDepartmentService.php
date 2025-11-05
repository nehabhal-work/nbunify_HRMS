<?php

namespace App\Services;

use App\Models\SubDepartment;

class SubDepartmentService
{
    public function getAll()
    {
        return SubDepartment::with('department')->get();
    }

    public function getById($id)
    {
        return SubDepartment::with('department')->findOrFail($id);
    }

    public function getByDepartmentId($departmentId)
    {
        return SubDepartment::where('department_id', $departmentId)->get();
    }

    public function create(array $data): SubDepartment
    {
        return SubDepartment::create($data);
    }

    public function update($id, array $data): SubDepartment
    {
        $subDepartment = SubDepartment::findOrFail($id);
        $subDepartment->update($data);
        return $subDepartment;
    }

    public function delete($id): bool
    {
        $subDepartment = SubDepartment::findOrFail($id);
        return $subDepartment->delete();
    }
}