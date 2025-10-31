<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'logo',
        'name',
        'company_type',
        'code',
        'domain',
        'watermark_no',
        'copyrights_no',
        'cin_no',
        'pan_no',
        'tan_no',
        'gstin',
        'udyam_aadhar_no',
        'partnership_registration_no',
        'roc_no',
        'msme_certification_no',
        'ckyc',
        'gumasta_no',
        'est_date',
        'registered_address',
        'registered_country',
        'registered_state',
        'registered_city',
        'registered_pincode',
        'corporate_address',
        'corporate_country',
        'corporate_state',
        'corporate_city',
        'corporate_pincode',
        'additional_address',
        'additional_country',
        'additional_state',
        'additional_city',
        'additional_pincode',
        'contact_person_name',
        'phone',
        'email',
        'attachment_pan',
        'attachment_tan',
        'attachment_gstin',
        'attachment_ckyc',
        'attachment_partnership_deed',
        'attachment_udyam_aadhar',
        'attachment_gumasta',
        'attachment_msme',
    ];

    protected $casts = [
        'est_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}