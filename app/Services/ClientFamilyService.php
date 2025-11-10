<?php

namespace App\Services;

use App\Models\ClientFamily;

class ClientFamilyService
{
    public function create(array $data): ClientFamily
    {
        return ClientFamily::create($data);
    }

    public function update(ClientFamily $clientFamily, array $data): ClientFamily
    {
        $clientFamily->update($data);
        return $clientFamily->fresh();
    }

    public function delete(ClientFamily $clientFamily): bool
    {
        return $clientFamily->delete();
    }

    public function getByClient(int $clientId): \Illuminate\Database\Eloquent\Collection
    {
        return ClientFamily::where('client_id', $clientId)->with('relation')->get();
    }
}