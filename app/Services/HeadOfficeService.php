<?php

namespace App\Services;

use App\Models\HeadOffice;

class HeadOfficeService
{

    public function getAll()
    {
        return HeadOffice::all();
    }

    public function paginate($filters, $perPage = 15)
    {
        return HeadOffice::query()
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('code', 'like', "%$search%");
            })
            ->when(isset($filters['company_id']), function ($q) use ($filters) {
                $q->where('company_id', $filters['company_id']);
            })
            ->latest()
            ->paginate($perPage);
    }

    public function store($data)
    {
        return HeadOffice::create($data);
    }

    public function update(HeadOffice $headOffice, $data)
    {
        $headOffice->update($data);
        return $headOffice;
    }

    public function delete(HeadOffice $headOffice)
    {
        return $headOffice->delete();
    }

    public function restore($id)
    {
        $record = HeadOffice::withTrashed()->findOrFail($id);
        $record->restore();
        return $record;
    }

    public function forceDelete($id)
    {
        $record = HeadOffice::withTrashed()->findOrFail($id);
        return $record->forceDelete();
    }
}
