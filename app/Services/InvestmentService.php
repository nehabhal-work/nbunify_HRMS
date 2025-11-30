<?php

namespace App\Services;

use App\Models\Investment;
use Illuminate\Database\Eloquent\Collection;

class InvestmentService
{
    public function create(array $data): Investment
    {
        return Investment::create($data);
    }

    public function update(Investment $investment, array $data): Investment
    {
        $investment->update($data);
        return $investment->fresh();
    }

    public function delete(Investment $investment): bool
    {
        return $investment->delete();
    }

    public function getAll(): Collection
    {
        return Investment::with(['client', 'scheme'])->get();
    }

    public function getById(int $id): Investment
    {
        return Investment::with(['client', 'scheme'])->findOrFail($id);
    }

    public function getByClient(int $clientId): Collection
    {
        return Investment::with(['client', 'scheme'])
            ->where('client_id', $clientId)
            ->get();
    }
}