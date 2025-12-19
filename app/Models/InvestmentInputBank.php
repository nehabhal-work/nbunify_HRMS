<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentInputBank extends Model
{
    protected $table = 'investment_input_banks';
    
    protected $fillable = [
        'investment_id',
        'from_client_bank_id',
        'to_company_bank_id',
        'instrument_type',
        'client_instrument_date',
        'client_reference_no',
        'amount',
        'attachment_instrument',
        'company_reference_no',
        'company_instrument_date',
    ];

    protected $casts = [
        'client_instrument_date' => 'date:Y-m-d',
        'company_instrument_date' => 'date:Y-m-d',
        'amount' => 'decimal:2',
    ];

    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }

    public function fromClientBank(): BelongsTo
    {
        return $this->belongsTo(ClientBank::class, 'from_client_bank_id');
    }

    public function toCompanyBank(): BelongsTo
    {
        return $this->belongsTo(CompanyBankDetail::class, 'to_company_bank_id');
    }
}