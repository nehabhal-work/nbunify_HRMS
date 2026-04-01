<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'head_office_id',
        'name',
        'code',
        'branch_type',
        'email',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'postal_code',
        'manager_name',
        'manager_email',
        'opening_hours',
        'employee_count',
        'status',
        'sort_order',
        'meta',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'opening_hours'  => 'array',
        'meta'           => 'array',
        'employee_count' => 'integer',
        'sort_order'     => 'integer',
    ];

    protected $attributes = [
        'branch_type'    => 'local',
        'status'         => 'active',
        'employee_count' => 0,
        'sort_order'     => 0,
    ];

    // ─── Constants ───────────────────────────────────────────────────────────────

    const BRANCH_TYPES = [
        'regional'  => 'Regional',
        'local'     => 'Local',
        'satellite' => 'Satellite',
    ];

    const STATUSES = [
        'active'   => 'Active',
        'inactive' => 'Inactive',
        'closed'   => 'Closed',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function headOffice()
    {
        return $this->belongsTo(HeadOffice::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeForHeadOffice($query, int $headOfficeId)
    {
        return $query->where('head_office_id', $headOfficeId);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('branch_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ─── Accessors ───────────────────────────────────────────────────────────────

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ])->filter()->implode(', ');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst($this->status);
    }

    public function getBranchTypeLabelAttribute(): string
    {
        return self::BRANCH_TYPES[$this->branch_type] ?? ucfirst($this->branch_type);
    }

    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active';
    }
}
