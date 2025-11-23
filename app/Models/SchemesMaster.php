<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemesMaster extends Model
{
    protected $table = 'schemes_master';  // your migration table name

    protected $fillable = [
        'start_date',
        'end_date',
        'scheme_name',
        'roi_min',
        'roi_max',
        'roi_additional',
        'tenure_type',
        'tenure_min',
        'tenure_max',
        'frequency',
    ];

    protected $casts = [
        'frequency' => 'array',     // ⭐ auto json encode/decode
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}
