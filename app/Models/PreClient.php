<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class PreClient extends Model
{
    protected $fillable = [
        'client_code',
        'name',
        'gender',
        'dob',
        'live_status',
        'dod',
        'marital_status',
        'nationality',
        'occupation',
        'pan_no',
        'aadhar_no',
        'ckyc_no',
        'mobile_no',
        'whatsapp_no',
        'landline_no',
        'email',
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
        'relation_manager_id',
        'remarks',
        'attachment_client_photo',
        'attachment_pan',
        'attachment_aadhar_front',
        'attachment_aadhar_back',
        'attachment_signature',
        'attachment_ckyc',
        'attachment_other_documents',
        'created_by',
        'approved_by',
        'approved_at',
        'approved2_by',
        'approved2_on',
        'approved3_by',
        'approved3_on',
    ];

    protected $casts = [
        'dob' => 'date:Y-m-d',
        'dod' => 'date:Y-m-d',
        'approved_at' => 'datetime:d-m-Y h:i',
        'approved2_on' => 'datetime:d-m-Y h:i',
        'approved3_on' => 'datetime:d-m-Y h:i',
    ];

    public function families(): HasMany
    {
        return $this->hasMany(PreClientFamily::class);
    }

    public function banks(): HasMany
    {
        return $this->hasMany(PreClientBank::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approved2By(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved2_by');
    }

    public function approved3By(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved3_by');
    }
}
