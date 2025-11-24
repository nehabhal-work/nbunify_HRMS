<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'gender',
        'dob',
        'phone',
        'email',
        'aadhar',
        'pan',
        'res_address',
        'res_state',
        'res_city',
        'res_pincode',
        'res_country_code',
        'res_state_code',
        'res_city_code',
        'branch_id',
        'deptment_id',
        'designation_id',
        'joining_date',
        'probation_date',
        'notice_date',
        'status',
        'reporting_manager',
        'role',
        'basic_salary',
        'hra',
        'travel_allowance',
        'conveyance_allowance',
        'medical_allowance',
        'bonus',
        'other_allowances',
        'prev_salary',
        'attachement_employee_photo',
        'attachement_aadhar',
        'attachment_release_letter',
        'attachment_expereance',
        'attachment_pan',
        'attachment_cv',
    ];

    protected $casts = [
        'dob' => 'date',
        'joining_date' => 'date',
        'basic_salary' => 'decimal:2',
        'hra' => 'decimal:2',
        'travel_allowance' => 'decimal:2',
        'conveyance_allowance' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'bonus' => 'decimal:2',
        'other_allowances' => 'decimal:2',
        'prev_salary' => 'decimal:2',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'deptment_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'reporting_manager');
    }

    public function subordinates()
    {
        return $this->hasMany(Employee::class, 'reporting_manager');
    }

    public function bankDetails()
    {
        return $this->hasMany(EmployeeBankDetail::class);
    }

    public function primaryBankDetail()
    {
        return $this->hasOne(EmployeeBankDetail::class)->where('is_primary', true);
    }
}
