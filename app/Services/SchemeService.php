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
        $data['scheme_code'] = $this->generateSchemeCode($data['scheme_name']);
        $data['exit_load_percent'] = $data['exit_load_percent'] ?? 0;
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

    public function generateSchemeCode(string $schemeName): string
    {
        $baseCode = 'ELS-' . strtoupper(substr(preg_replace('/\s+/', '', $schemeName), 0, 3)) . '-';
        $counter = 1;

        do {
            $code = $baseCode . str_pad($counter, 4, '0', STR_PAD_LEFT);
            $counter++;
        } while (SchemesMaster::where('scheme_code', $code)->exists());

        return $code;
    }
}
