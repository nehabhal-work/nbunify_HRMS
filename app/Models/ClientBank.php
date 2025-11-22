<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientBank extends Model
{
    protected $fillable = [
        'client_id',
        'ifsc_code',
        'account_number',
        'bank_name',
        'branch_name',
        'bank_code',
        'is_primary',
        'account_type',
        'attachment_cancelled_cheque',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
