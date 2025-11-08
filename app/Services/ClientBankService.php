<?php

namespace App\Services;

use App\Models\ClientBank;

class ClientBankService
{
    public function create(array $data): ClientBank
    {
        if ($data['is_primary'] ?? false) {
            $this->unsetPrimaryBanks($data['client_id']);
        }
        
        return ClientBank::create($data);
    }

    public function update(ClientBank $clientBank, array $data): ClientBank
    {
        if ($data['is_primary'] ?? false) {
            $this->unsetPrimaryBanks($clientBank->client_id, $clientBank->id);
        }
        
        $clientBank->update($data);
        return $clientBank->fresh();
    }

    public function delete(ClientBank $clientBank): bool
    {
        return $clientBank->delete();
    }

    public function getByClient(int $clientId): \Illuminate\Database\Eloquent\Collection
    {
        return ClientBank::where('client_id', $clientId)->get();
    }

    private function unsetPrimaryBanks(int $clientId, ?int $excludeId = null): void
    {
        $query = ClientBank::where('client_id', $clientId)->where('is_primary', true);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        $query->update(['is_primary' => false]);
    }
}