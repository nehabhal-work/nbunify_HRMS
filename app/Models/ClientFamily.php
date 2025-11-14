<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClientFamily extends Model
{
    protected $fillable = [
        'client_code',
        'client_id',
        'name',
        'gender',
        'dob',
        'live_status',
        'dod',
        'marital_status',
        'nationality',
        'occupation',
        'mobile_no',
        'whatsapp_no',
        'landline_no',
        'email',
        'res_address',
        'res_country',
        'res_state',
        'res_city',
        'res_pincode',
        'office_address',
        'office_country',
        'office_state',
        'office_city',
        'office_pincode',
        'relation_id',
        'remarks',
    ];

    protected $casts = [
        'dob' => 'date',
        'dod' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function relation(): BelongsTo
    {
        return $this->belongsTo(FamilyRelation::class);
    }
}
