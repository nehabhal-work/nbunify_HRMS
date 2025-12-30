<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'financial_year',
        'vendor_id',
        'invoice_no',
        'bill_date',
        'total_amount'
    ];

    protected $casts = [
        'bill_date' => 'date',
        'total_amount' => 'decimal:2'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }
}
