<?php

namespace App\Services;

use App\Models\SchemesMaster;

class SchemeService
{
    public function __construct()
    {
    }

    public function getAll()
    {
        return SchemesMaster::all();
    }

    public function find($id)
    {
        return SchemesMaster::findOrFail($id);
    }

    public function create(array $data): SchemesMaster
    {
        return SchemesMaster::create($data);
    }

    public function update(SchemesMaster $scheme, array $data): SchemesMaster
    {
        $scheme->update($data);
        return $scheme->fresh();
    }

    public function delete(SchemesMaster $scheme): bool
    {
        return $scheme->delete();
    }
}
