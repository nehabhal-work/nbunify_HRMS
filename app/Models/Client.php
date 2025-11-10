<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
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
        'res_state',
        'res_city',
        'res_pincode',
        'office_address',
        'office_country',
        'office_state',
        'office_city',
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
    ];

    protected $casts = [
        'dob' => 'date',
        'dod' => 'date',
    ];

    public function families(): HasMany
    {
        return $this->hasMany(ClientFamily::class);
    }

    public function banks(): HasMany
    {
        return $this->hasMany(ClientBank::class);
    }
}
