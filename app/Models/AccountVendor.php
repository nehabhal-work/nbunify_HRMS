<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccountVendor extends Model
{
    protected $table = 'account_vendors';

    protected $fillable = [
        // Type
        'opt_client_vendor',
        'vendor_code',
        // Entity
        'entity_type',
        'non_individual_type',

        // Tax
        'gst_mode',
        'gst_no',
        'pan',
        'tan_no',
        'vat_no',
        'cin',
        'aadhar_no',

        // Classification
        'client_type',
        'under_head',

        // Financial
        'service_charges',

        // Primary
        'client_name',
        'vendor_mobile',
        'vendor_email',

        // Contact
        'contact_person_name',
        'contact_email',
        'contact_mobile',

        // Address
        'res_address',
        'res_country',
        'res_country_code',
        'res_state',
        'res_state_code',
        'res_city',
        'res_city_code',
        'res_pincode',

        // Remarks
        'remarks',

        // Attachments
        'attachement_user_photo',
        'attachment_pan',
        'attachement_aadhar',
        'attachment_gst',
        'attachment_other_documents',
        'attachment_cancelled_cheque',

        // Bank
        'ifsc_code',
        'account_number',
        'bank_name',
        'branch_name',
        'bank_code',

        // System
        'is_active',
        'created_by',
        'approved_by',
        'approved_at',
        'approved2_by',
        'approved2_on',
        'approved3_by',
        'approved3_on',
    ];

    protected $casts = [
        'service_charges' => 'decimal:2',
        'is_active'       => 'boolean',
        'approved_at'     => 'datetime',
        'approved2_on'    => 'datetime',
        'approved3_on'    => 'datetime',
    ];

    /* Scopes */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
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
