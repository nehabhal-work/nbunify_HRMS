<?php

namespace App\Services;

use App\Models\HeadOffice;

class HeadOfficeService
{

    public function find($id) {
        return HeadOffice::findOrFail($id);
    }

    public function getAllHeadOffices()
    {
        return HeadOffice::all();
    }

    public function createHeadOffice(array $data)
    {
        return HeadOffice::create($data);
    }

    public function getHeadOfficeById($id)
    {
        return HeadOffice::findOrFail($id);
    }

    public function updateHeadOffice($id, array $data)
    {
        $headOffice = HeadOffice::findOrFail($id);
        $headOffice->update($data);
        return $headOffice;
    }

    public function deleteHeadOffice($id)
    {
        $headOffice = HeadOffice::findOrFail($id);
        return $headOffice->delete();
    }
}
