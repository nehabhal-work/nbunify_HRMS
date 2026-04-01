<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOffice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'code',
        'email',
        'phone',
        'fax',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'pincode',
        'timezone',
        'currency',
        'manager_name',
        'manager_email',
        'established_at',
        'is_active',
        'meta',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
        'established_at' => 'date',
    ];

    // रिलेशनशिप
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // ─── Accessors ───────────────────────────────────────────────────────────────

    public function getFullAddressAttribute(): string
    {
        return collect([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->pincode,
            $this->country,
        ])->filter()->implode(', ');
    }
}
