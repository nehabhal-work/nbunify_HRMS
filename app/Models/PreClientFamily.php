<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreClientFamily extends Model
{
    protected $fillable = [
        'client_code',
        'preclient_id',
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
        'pan_no',
        'aadhar_no',
        'res_address',
        'res_country',
        'res_country_code',
        'res_state',
        'res_state_code',
        'res_city',
        'res_city_code',
        'res_pincode',
        'office_address',
        'office_country',
        'office_country_code',
        'office_state',
        'office_state_code',
        'office_city',
        'office_city_code',
        'office_pincode',
        'relation_id',
        'remarks',
    ];

    protected $casts = [
        'dob' => 'date',
        'dod' => 'date',
    ];

    public function preclient(): BelongsTo
    {
        return $this->belongsTo(PreClient::class);
    }

    public function relation(): BelongsTo
    {
        return $this->belongsTo(FamilyRelation::class);
    }
}
