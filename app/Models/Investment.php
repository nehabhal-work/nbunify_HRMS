<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investment extends Model
{
    protected $fillable = [
        'investment_date',
        'investment_type',
        'first_client_id',
        'second_client_id',
        'third_client_id',
        'fourth_client_id',
        'scheme_id',
        'investment_amount',
        'tenure_type',
        'tenure_count',
        'frequency',
        'roi_percent',
        'additional_roi_percent',
        'has_tds',
        'attachment_tds',
        'from_company_bank_id',
        'to_client_bank_id',
        'schedule_count',
        'annual_payout',
        'payout_per_period',
        'maturity_date',
        'first_payout_date',
        'actual_interest_amount',
        'paid_interest_amount',
        'rounding_off_amount',
    ];

    protected $casts = [
        'investment_date' => 'date:Y-m-d',
        'maturity_date' => 'date:Y-m-d',
        'first_payout_date' => 'date:Y-m-d',
        'has_tds' => 'boolean',
        'investment_amount' => 'decimal:2',
        'roi_percent' => 'decimal:2',
        'additional_roi_percent' => 'decimal:2',
        'annual_payout' => 'decimal:2',
        'payout_per_period' => 'decimal:2',
        'actual_interest_amount' => 'decimal:2',
        'paid_interest_amount' => 'decimal:2',
        'rounding_off_amount' => 'decimal:2',
    ];

    public function firstClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'first_client_id');
    }

    public function secondClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'second_client_id');
    }

    public function thirdClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'third_client_id');
    }

    public function fourthClient(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'fourth_client_id');
    }

    public function scheme(): BelongsTo
    {
        return $this->belongsTo(SchemesMaster::class, 'scheme_id');
    }

    public function fromCompanyBank(): BelongsTo
    {
        return $this->belongsTo(CompanyBankDetail::class, 'from_company_bank_id');
    }

    public function toClientBank(): BelongsTo
    {
        return $this->belongsTo(ClientBank::class, 'to_client_bank_id');
    }

    public function inputBanks(): HasMany
    {
        return $this->hasMany(InvestmentInputBank::class);
    }

    public function nominees(): HasMany
    {
        return $this->hasMany(InvestmentNominee::class);
    }

    public function standingInstructions(): HasMany
    {
        return $this->hasMany(InvestmentSi::class);
    }

    public function payoutSchedules(): HasMany
    {
        return $this->hasMany(InvestmentPayoutSchedule::class);
    }
}
