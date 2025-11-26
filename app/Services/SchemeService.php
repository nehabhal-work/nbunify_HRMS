<?php

namespace App\Services;

use App\Models\SchemesMaster;

class SchemeService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function createScheme(array $data): SchemesMaster
    {
        return SchemesMaster::create($data);
    }

    public function updateScheme(SchemesMaster $scheme, array $data): SchemesMaster
    {
        $scheme->update($data);
        return $scheme;
    }

    // public function deleteScheme($id): bool
    // {
    //     return $SchemesMaster->delete();
    // }

    public function deleteScheme($id)
    {
        $scheme = SchemesMaster::findOrFail($id);
        return $scheme->delete();
    }

    public function find($id)
    {
        return SchemesMaster::findOrFail($id);
    }
}
