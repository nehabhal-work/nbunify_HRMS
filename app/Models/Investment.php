<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;

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
        'status',
        'action_status',
        'exit_load_percent',
        'lock_in_period',
        'lock_in_period_type',
        'created_by',
        'approved_by',
        'approved_at',
        'approved2_by',
        'approved2_on',
        'approved3_by',
        'approved3_on',
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
        'exit_load_percent' => 'decimal:2',
        'approved_at' => 'datetime:d-m-Y h:i',
        'approved2_on' => 'datetime:d-m-Y h:i',
        'approved3_on' => 'datetime:d-m-Y h:i',
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
        return $this->hasMany(InvestmentSi::class, 'investment_id', 'id');
    }

    public function InvestmentInputBank(): HasMany
    {
        return $this->hasMany(InvestmentInputBank::class);
    }


    public function payoutSchedules(): HasMany
    {
        return $this->hasMany(InvestmentPayoutSchedule::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approved2By(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved2_by');
    }

    public function approved3By(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved3_by');
    }
}
