<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'particular',
        'hsn',
        'amount',
        'quantity',
        'bill_amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'quantity' => 'decimal:2',
        'bill_amount' => 'decimal:2'
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
