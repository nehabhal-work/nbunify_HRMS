<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function createSale(array $data): Sale
    {
        return DB::transaction(function () use ($data) {
            $sale = Sale::create([
                'financial_year' => $data['financial_year'],
                'customer_id' => $data['customer_id'],
                'invoice_no' => $data['invoice_no'],
                'bill_date' => $data['bill_date'],
                'total_amount' => array_sum($data['bill_amount'])
            ]);

            foreach ($data['particular'] as $index => $particular) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'particular' => $particular,
                    'hsn' => $data['hsn'][$index] ?? null,
                    'amount' => $data['amount'][$index],
                    'quantity' => $data['quantity'][$index],
                    'bill_amount' => $data['bill_amount'][$index]
                ]);
            }

            return $sale->load('saleItems');
        });
    }

    public function updateSale(Sale $sale, array $data): Sale
    {
        return DB::transaction(function () use ($sale, $data) {
            $sale->update([
                'financial_year' => $data['financial_year'],
                'customer_id' => $data['customer_id'],
                'invoice_no' => $data['invoice_no'],
                'bill_date' => $data['bill_date'],
                'total_amount' => array_sum($data['bill_amount'])
            ]);

            $sale->saleItems()->delete();

            foreach ($data['particular'] as $index => $particular) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'particular' => $particular,
                    'hsn' => $data['hsn'][$index] ?? null,
                    'amount' => $data['amount'][$index],
                    'quantity' => $data['quantity'][$index],
                    'bill_amount' => $data['bill_amount'][$index]
                ]);
            }

            return $sale->load('saleItems');
        });
    }
}