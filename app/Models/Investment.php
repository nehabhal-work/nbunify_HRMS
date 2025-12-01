<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Investment extends Model
{
    protected $fillable = [
        'investment_date',
        'investment_type',
        'client_id',
        'other_holders',
        'scheme_id',
        'investment_amount',
        'tenure_type',
        'tenure_count',
        'frequency',
        'roi_percent',
        'additional_roi_percent',
        'maturity_date',
        'payout_amount',
        'has_tds',
    ];

    protected $casts = [
        'investment_date' => 'date:Y-m-d',
        'maturity_date' => 'date:Y-m-d',
        'other_holders' => 'array',
        'has_tds' => 'boolean',
        'investment_amount' => 'decimal:2',
        'roi_percent' => 'decimal:2',
        'additional_roi_percent' => 'decimal:2',
        'payout_amount' => 'decimal:2',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function scheme(): BelongsTo
    {
        return $this->belongsTo(SchemesMaster::class, 'scheme_id');
    }
}
