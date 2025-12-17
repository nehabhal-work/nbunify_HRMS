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
    ];

    protected $casts = [
        'frequency' => 'array',
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}
