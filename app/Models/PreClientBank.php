<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreClientBank extends Model
{
    protected $table = 'preclient_banks';

    protected $fillable = [
        'preclient_id',
        'ifsc_code',
        'account_number',
        'bank_name',
        'branch_name',
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

    public function preclient(): BelongsTo
    {
        return $this->belongsTo(PreClient::class,'preclient_id','id');
    }
}
