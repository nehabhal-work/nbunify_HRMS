<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'code',
        'contact_person',
        'phone',
        'email',
        'address',
        'gst_number',
        'pan_number',
        'country_code',
        'state',
        'city',
        'postal_code',
    ];

    protected $casts = [
        'est_date' => 'date',
    ];
}