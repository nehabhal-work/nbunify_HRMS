<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'branch_id',
        'head_office_id',
        'parent_id',
        'name',
        'code',
        'description',
        'dept_type',
        'email',
        'phone_ext',
        'head_name',
        'head_email',
        'budget',
        'cost_centre',
        'employee_count',
        'is_active',
        'sort_order',
        'meta',
    ];

    protected $casts = [
        'budget'         => 'decimal:2',
        'employee_count' => 'integer',
        'sort_order'     => 'integer',
        'is_active'      => 'boolean',
        'meta'           => 'array',
    ];

    protected $attributes = [
        'is_active'      => true,
        'employee_count' => 0,
        'sort_order'     => 0,
    ];

    // ─── Constants ───────────────────────────────────────────────────────────────

    const DEPT_TYPES = [
        'operational' => 'Operational',
        'support'     => 'Support',
        'admin'       => 'Admin',
    ];

    // ─── Relationships ───────────────────────────────────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function headOffice()
    {
        return $this->belongsTo(HeadOffice::class);
    }

    /** Parent department (self-referential) */
    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }

    /** Direct child departments */
    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id')->orderBy('sort_order')->orderBy('name');
    }

    /** Recursively nested children (full tree) */
    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    // ─── Scopes ──────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeForCompany($query, int $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeForBranch($query, int $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    public function scopeForHeadOffice($query, int $headOfficeId)
    {
        return $query->where('head_office_id', $headOfficeId);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('dept_type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ─── Accessors ───────────────────────────────────────────────────────────────

    public function getDeptTypeLabelAttribute(): string
    {
        return self::DEPT_TYPES[$this->dept_type] ?? ucfirst($this->dept_type);
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Active' : 'Inactive';
    }

    public function getIsRootAttribute(): bool
    {
        return is_null($this->parent_id);
    }

    public function getHasChildrenAttribute(): bool
    {
        return $this->children()->exists();
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────────

    /**
     * Return flat array of all ancestor IDs (root → parent → self)
     */
    public function ancestorIds(): array
    {
        $ids    = [];
        $cursor = $this->parent;

        while ($cursor) {
            $ids[]  = $cursor->id;
            $cursor = $cursor->parent;
        }

        return array_reverse($ids);
    }

    /**
     * Prevent circular parent assignment
     */
    public function wouldCreateCycle(int $newParentId): bool
    {
        if ($newParentId === $this->id) {
            return true;
        }

        $parent = Department::find($newParentId);
        while ($parent) {
            if ($parent->parent_id === $this->id) {
                return true;
            }
            $parent = $parent->parent;
        }

        return false;
    }
}
