<?php

namespace App\Services;

use App\Models\SubDesignation;

class SubDesignationService
{
    public function getAll()
    {
        return SubDesignation::with('designation')->get();
    }

    public function getById($id)
    {
        return SubDesignation::with('designation')->findOrFail($id);
    }

    public function getByDesignationId($designationId)
    {
        return SubDesignation::where('designation_id', $designationId)->get();
    }

    public function create(array $data): SubDesignation
    {
        return SubDesignation::create($data);
    }

    public function update($id, array $data): SubDesignation
    {
        $subDesignation = SubDesignation::findOrFail($id);
        $subDesignation->update($data);
        return $subDesignation;
    }

    public function delete($id): bool
    {
        $subDesignation = SubDesignation::findOrFail($id);
        return $subDesignation->delete();
    }
}