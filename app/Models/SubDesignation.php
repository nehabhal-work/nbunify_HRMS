<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubDesignation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'designation_id',
        'title',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function designation(): BelongsTo
    {
        return $this->belongsTo(Designation::class);
    }
}