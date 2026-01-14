<?php

namespace App\Services;

use App\Models\PreClientFamily;

class PreClientFamilyService
{
    public function find($id)
    {
        return PreClientFamily::findOrFail($id);
    }

    public function create(array $data): PreClientFamily
    {
        return PreClientFamily::create($data);
    }

    public function update(PreClientFamily $preClientFamily, array $data): PreClientFamily
    {
        $preClientFamily->update($data);
        return $preClientFamily->fresh();
    }

    public function delete($id): bool
    {
        $preClientFamily = PreClientFamily::findOrFail($id);
        return $preClientFamily->delete();
    }

    public function getByPreClient(int $preclientId): \Illuminate\Database\Eloquent\Collection
    {
        return PreClientFamily::where('preclient_id', $preclientId)->with('preclient', 'relation')->get();
    }
}