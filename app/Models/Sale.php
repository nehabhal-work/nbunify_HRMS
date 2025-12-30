<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'financial_year',
        'customer_id',
        'invoice_no',
        'bill_date',
        'total_amount'
    ];

    protected $casts = [
        'bill_date' => 'date',
        'total_amount' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
