<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class SaleFinalizer
{
    public function finalizePaidSale(int $saleId): void
    {
        DB::transaction(function () use ($saleId) {

            $sale = DB::table('sales')->where('id', $saleId)->lockForUpdate()->first();
            if (!$sale) {
                throw new \Exception("Sale not found.");
            }

            // already paid? stop
            if (($sale->payment_status ?? null) === 'paid') {
                return;
            }

            // mark paid
            DB::table('sales')->where('id', $saleId)->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'updated_at' => now(),
            ]);

            // (OPTIONAL) If you want stock-out only AFTER payment:
            // - move your stock decrement + transactions insert here
            // - and in POS store, create sale as pending without stock decrement
        });
    }
}