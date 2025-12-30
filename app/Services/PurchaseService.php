<?php

namespace App\Services;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Facades\DB;

class PurchaseService
{
    public function createPurchase(array $data): Purchase
    {
        return DB::transaction(function () use ($data) {
            $purchase = Purchase::create([
                'financial_year' => $data['financial_year'],
                'vendor_id' => $data['vendor_id'],
                'invoice_no' => $data['invoice_no'],
                'bill_date' => $data['bill_date'],
                'total_amount' => array_sum($data['bill_amount'])
            ]);

            foreach ($data['particular'] as $index => $particular) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'particular' => $particular,
                    'hsn' => $data['hsn'][$index] ?? null,
                    'amount' => $data['amount'][$index],
                    'quantity' => $data['quantity'][$index],
                    'bill_amount' => $data['bill_amount'][$index]
                ]);
            }

            return $purchase->load('purchaseItems');
        });
    }

    public function updatePurchase(Purchase $purchase, array $data): Purchase
    {
        return DB::transaction(function () use ($purchase, $data) {
            $purchase->update([
                'financial_year' => $data['financial_year'],
                'vendor_id' => $data['vendor_id'],
                'invoice_no' => $data['invoice_no'],
                'bill_date' => $data['bill_date'],
                'total_amount' => array_sum($data['bill_amount'])
            ]);

            $purchase->purchaseItems()->delete();

            foreach ($data['particular'] as $index => $particular) {
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'particular' => $particular,
                    'hsn' => $data['hsn'][$index] ?? null,
                    'amount' => $data['amount'][$index],
                    'quantity' => $data['quantity'][$index],
                    'bill_amount' => $data['bill_amount'][$index]
                ]);
            }

            return $purchase->load('purchaseItems');
        });
    }
}