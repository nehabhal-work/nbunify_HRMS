<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvestmentSi extends Model
{
    use HasFactory, SoftDeletes;

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
    ];

    protected $casts = [
        'si_start_date' => 'date',
        'si_amount' => 'decimal:2',
        'si_no_of_payments' => 'integer',
    ];

    public function investment()
    {
        return $this->belongsTo(Investment::class);
    }

    public function clientBank()
    {
        return $this->belongsTo(ClientBank::class, 'si_client_bank_id');
    }

    public function companyBank()
    {
        return $this->belongsTo(CompanyBankDetail::class, 'si_company_bank_id');
    }
}