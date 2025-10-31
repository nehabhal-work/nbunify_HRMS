<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOffice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'contact_person',
        'country',
        'state',
        'city',
        'pincode',
        'code',
        'contact_person_designation',
    ];
}
