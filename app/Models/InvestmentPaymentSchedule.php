<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestmentPaymentSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'investment_id',
        'payout_date',
        'amount',
        'actual_payout_date',
        'status',
        'remarks',
        'actual_payout_amount',
        'reference_no',
        'company_bank_id',
        'client_bank_id',
    ];

    protected $casts = [
        'payout_date' => 'date',
        'actual_payout_date' => 'datetime',
        'amount' => 'decimal:2',
        'actual_payout_amount' => 'decimal:2',
    ];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function companyBank()
    {
        return $this->belongsTo(CompanyBankDetail::class, 'company_bank_id');
    }

    public function clientBank()
    {
        return $this->belongsTo(ClientBank::class, 'client_bank_id');
    }
}
