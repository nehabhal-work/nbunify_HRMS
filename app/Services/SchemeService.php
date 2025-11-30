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
        $data['scheme_code'] = $this->generateSchemeCode();
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

    public function generateSchemeCode(): string
    {
        $baseCode = 'ELS-SC-';
        $counter = 1;

        do {
            $code = $baseCode . str_pad($counter, 8, '0', STR_PAD_LEFT);
            $counter++;
        } while (SchemesMaster::where('scheme_code', $code)->exists());

        return $code;
    }
}
