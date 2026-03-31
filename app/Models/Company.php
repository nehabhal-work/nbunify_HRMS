<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'companies';
    protected $fillable = [
        // Basic Info
        'name',
        'legal_name',
        'company_type',
        'website',
        'logo',

        // Registration Numbers
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

        // Establishment Date
        'est_date',

        // Attachments
        'attachment_pan',
        'attachment_tan',
        'attachment_gstin',
        'attachment_ckyc',
        'attachment_partnership_deed',
        'attachment_udyam_aadhar',
        'attachment_gumasta',
        'attachment_msme',

        // Audit
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'est_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // ─── Company Type Options ────────────────────────────────────────────────────

    const COMPANY_TYPES = [
        'sole_proprietorship' => 'Sole Proprietorship',
        'partnership'         => 'Partnership',
        'pvt_ltd'             => 'Private Limited',
        'public_ltd'          => 'Public Limited',
        'llp'                 => 'LLP',
        'huf'                 => 'HUF',
        'ngo'                 => 'NGO',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────────

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ─── Accessors ───────────────────────────────────────────────────────────────

    public function getCompanyTypeLabelAttribute(): string
    {
        return self::COMPANY_TYPES[$this->company_type] ?? ucfirst($this->company_type);
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    // Attachment URL accessors
    public function getAttachmentPanUrlAttribute(): ?string
    {
        return $this->attachment_pan ? asset('storage/' . $this->attachment_pan) : null;
    }

    public function getAttachmentTanUrlAttribute(): ?string
    {
        return $this->attachment_tan ? asset('storage/' . $this->attachment_tan) : null;
    }

    public function getAttachmentGstinUrlAttribute(): ?string
    {
        return $this->attachment_gstin ? asset('storage/' . $this->attachment_gstin) : null;
    }

    public function getAttachmentCkycUrlAttribute(): ?string
    {
        return $this->attachment_ckyc ? asset('storage/' . $this->attachment_ckyc) : null;
    }

    public function getAttachmentPartnershipDeedUrlAttribute(): ?string
    {
        return $this->attachment_partnership_deed ? asset('storage/' . $this->attachment_partnership_deed) : null;
    }

    public function getAttachmentUdyamAadharUrlAttribute(): ?string
    {
        return $this->attachment_udyam_aadhar ? asset('storage/' . $this->attachment_udyam_aadhar) : null;
    }

    public function getAttachmentGumastaUrlAttribute(): ?string
    {
        return $this->attachment_gumasta ? asset('storage/' . $this->attachment_gumasta) : null;
    }

    public function getAttachmentMsmeUrlAttribute(): ?string
    {
        return $this->attachment_msme ? asset('storage/' . $this->attachment_msme) : null;
    }
}
