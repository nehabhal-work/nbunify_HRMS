<?php

namespace App\Services;

use App\Models\FamilyRelation;

class FamilyRelationService
{
    public function getAll()
    {
        return FamilyRelation::all();
    }

    public function getByGender($gender) {
        return FamilyRelation::where('gender', $gender)->get();
    }

    public function getById($id)
    {
        return FamilyRelation::findOrFail($id);
    }

    public function create(array $data): FamilyRelation
    {
        return FamilyRelation::create($data);
    }

    public function update($id, array $data): FamilyRelation
    {
        $familyRelation = FamilyRelation::findOrFail($id);
        $familyRelation->update($data);
        return $familyRelation;
    }

    public function delete($id): bool
    {
        $familyRelation = FamilyRelation::findOrFail($id);
        return $familyRelation->delete();
    }
}
