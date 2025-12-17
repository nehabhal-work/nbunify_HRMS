<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentNominee extends Model
{
    protected $fillable = [
        'investment_id',
        'client_family_id',
        'guardian_client_family_id',
        'percent',
    ];

    protected $casts = [
        'percent' => 'decimal:2',
    ];

    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }

    public function clientFamily(): BelongsTo
    {
        return $this->belongsTo(ClientFamily::class, 'client_family_id');
    }

    public function guardianClientFamily(): BelongsTo
    {
        return $this->belongsTo(ClientFamily::class, 'guardian_client_family_id');
    }
}