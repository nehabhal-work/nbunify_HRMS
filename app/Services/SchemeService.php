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

    public function deleteScheme(SchemesMaster $scheme): bool
    {
        return $scheme->delete();
    }
}
