<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyBankDetail extends Model
{
    protected $fillable = [
        'company_id',
        'account_number',
        'ifsc_code',
        'bank_name',
        'branch_name',
        'is_primary',
        'bank_code',
        'account_type',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
