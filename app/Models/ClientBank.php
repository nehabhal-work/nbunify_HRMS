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
        'branch_n58ame',
        'bank_code',
        'is_primary',
        'account_type',
        'attachment_cancelled_cheque',
        'operation_mode',
        'holder_name_1',
        'holder_name_2',
        'holder_name_3',
        'micrcode',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
