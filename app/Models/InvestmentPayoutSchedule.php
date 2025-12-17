<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentPayoutSchedule extends Model
{
    protected $fillable = [
        'investment_id',
        'sch_payout_date',
        'sch_payout_amount',
        'actual_payout_date',
        'status',
        'remarks',
        'actual_payout_amount',
        'utr_no',
        'from_company_bank_id',
        'to_client_bank_id',
    ];

    protected $casts = [
        'sch_payout_date' => 'date:Y-m-d',
        'actual_payout_date' => 'date:Y-m-d',
        'sch_payout_amount' => 'decimal:2',
        'actual_payout_amount' => 'decimal:2',
    ];

    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }

    public function fromCompanyBank(): BelongsTo
    {
        return $this->belongsTo(CompanyBankDetail::class, 'from_company_bank_id');
    }

    public function toClientBank(): BelongsTo
    {
        return $this->belongsTo(ClientBank::class, 'to_client_bank_id');
    }
}