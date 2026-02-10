<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemesMaster extends Model
{
    protected $table = 'schemes_master';  // your migration table name

    protected $fillable = [
        'scheme_code',
        'start_date',
        'end_date',
        'scheme_name',
        'name_type',
        'roi_min',
        'roi_max',
        'roi_min_additional',
        'roi_max_additional',
        'tenure_type',
        'tenure_min',
        'tenure_max',
        'frequency',
        'exit_load_percent',
        'lock_in_period',
        'lock_in_period_type',
        'created_by',
        'approved_by',
        'approved_at',
        'approved2_by',
        'approved2_on',
        'approved3_by',
        'approved3_on',
    ];

    protected $casts = [
        'frequency' => 'array',
        'start_date' => 'date',
        'end_date'   => 'date',
        'approved_at' => 'datetime',
        'approved2_on' => 'datetime',
        'approved3_on' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    public function approved2By()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved2_by');
    }

    public function approved3By()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved3_by');
    }
}
