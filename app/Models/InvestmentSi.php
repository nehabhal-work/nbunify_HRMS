<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvestmentSi extends Model
{
    protected $table = 'investment_si';

    protected $fillable = [
        'investment_id',
        'si_number',
        'si_client_bank_id',
        'si_company_bank_id',
        'si_start_date',
        'si_amount',
        'si_no_of_payments',
        'attachment_si_image',
        'attachment_notes_image',
        'status',
    ];

    protected $casts = [
        'si_start_date' => 'date:Y-m-d',
        'si_amount' => 'decimal:2',
        'status' => 'string',
    ];

    public function investment(): BelongsTo
    {
        return $this->belongsTo(Investment::class);
    }

    public function siClientBank(): BelongsTo
    {
        return $this->belongsTo(ClientBank::class, 'si_client_bank_id');
    }

    public function siCompanyBank(): BelongsTo
    {
        return $this->belongsTo(CompanyBankDetail::class, 'si_company_bank_id');
    }
}
