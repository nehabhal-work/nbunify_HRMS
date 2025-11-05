<?php

namespace App\Services;

use App\Models\Designation;

class DesignationService
{
    public function getAll()
    {
        return Designation::with('subDesignations')->get();
    }

    public function getById($id)
    {
        return Designation::with('subDesignations')->findOrFail($id);
    }

    public function create(array $data): Designation
    {
        return Designation::create($data);
    }

    public function update($id, array $data): Designation
    {
        $designation = Designation::findOrFail($id);
        $designation->update($data);
        return $designation;
    }

    public function delete($id): bool
    {
        $designation = Designation::findOrFail($id);
        return $designation->delete();
    }
}