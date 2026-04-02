<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyBank extends Model
{
    protected $table = 'company_banks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'bank_name',
        'branch_name',
        'ifsc_code',
        'account_number',
        'account_type',
        'bank_code',
        'is_primary',
        'created_by',
        'updated_by',
    ];
}
