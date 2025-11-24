<?php

namespace App\Services;

use App\Models\Branch;

class BranchService
{


    public function __construct()
    {
    }

    public function getAll()
    {
        return Branch::all();
    }
    
    public function find($id) {
        return Branch::findOrFail($id);
    }

    public function getAllBranches()
    {
        return Branch::all();
    }

    public function createBranch(array $data)
    {
        return Branch::create($data);
    }

    public function getBranchById($id)
    {
        return Branch::findOrFail($id);
    }

    public function updateBranch($id, array $data)
    {
        $branch = Branch::findOrFail($id);
        $branch->update($data);
        return $branch;
    }

    public function deleteBranch($id)
    {
        $branch = Branch::findOrFail($id);
        return $branch->delete();
    }
}
