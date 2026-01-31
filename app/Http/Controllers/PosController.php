<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function create()
    {
        $products = DB::table('products')
            ->select('id', 'name', 'sku', 'price', 'stock', 'image_path')
            ->orderByDesc('id')
            ->get();

        $promos = DB::table('promotions')
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->get();

        $customers = DB::table('customers')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        // IMPORTANT: do NOT pass $sale to this page (POS page has no $sale)
        return view('admin.pos', compact('products', 'promos', 'customers'));
    }

    /**
     * Main POS submit
     * - cash/card => paid immediately (stock out + transactions now)
     * - qr => pending (no stock change yet) + show QR page
     */
    public function checkout(Request $request)
    {
        if (is_string($request->items)) {
            $request->merge(['items' => json_decode($request->items, true)]);
        }

        $data = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'payment_type' => ['required', 'in:cash,qr,card'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
        ]);

        $tax = (float) ($data['tax'] ?? 0);
        $paymentType = $data['payment_type'];

        $result = DB::transaction(function () use ($data, $tax, $paymentType) {

            $productIds = collect($data['items'])->pluck('product_id')->unique()->values();

            $products = DB::table('products')
                ->whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // 1) subtotal + stock check
            $subtotal = 0;
            foreach ($data['items'] as $item) {
                $p = $products->get($item['product_id']);
                if (!$p)
                    throw new \Exception("Product not found.");

                $qty = (int) $item['qty'];
                if ($qty > (int) $p->stock) {
                    throw new \Exception("Not enough stock for: {$p->name}");
                }

                $subtotal += $qty * (float) $p->price;
            }

            // 2) best promotion discount
            $promos = DB::table('promotions')->where('is_active', 1)->get();
            $discount = 0;

            foreach ($promos as $promo) {
                $min = (float) ($promo->min_amount ?? 0);
                if ($subtotal < $min)
                    continue;

                $d = ($promo->type === 'percent')
                    ? $subtotal * ((float) $promo->value / 100)
                    : (float) $promo->value;

                if ($d > $discount)
                    $discount = $d;
            }

            $discount = min($discount, $subtotal);
            $finalTotal = max(0, $subtotal - $discount + $tax);

            // 3) payment status
            $paymentStatus = ($paymentType === 'qr') ? 'pending' : 'paid';
            $paidAt = ($paymentStatus === 'paid') ? now() : null;

            // 4) create sale
            $saleId = DB::table('sales')->insertGetId([
                'user_id' => auth()->id(),
                'customer_id' => $data['customer_id'] ?? null,
                'invoice_number' => 'TEMP',
                'total_amount' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'final_total' => $finalTotal,
                'payment_type' => $paymentType,

                // make sure these columns exist in sales table
                'payment_status' => $paymentStatus,
                'paid_at' => $paidAt,

                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 5) invoice number
            $invoice = 'INV-' . now()->format('Y') . '-' . str_pad((string) $saleId, 6, '0', STR_PAD_LEFT);
            DB::table('sales')->where('id', $saleId)->update([
                'invoice_number' => $invoice,
                'updated_at' => now(),
            ]);

            // 6) save sale_items
            foreach ($data['items'] as $item) {
                $p = $products->get($item['product_id']);
                $qty = (int) $item['qty'];
                $price = (float) $p->price;

                DB::table('sale_items')->insert([
                    'sale_id' => $saleId,
                    'product_id' => $p->id,
                    'qty' => $qty,
                    'price' => $price,
                    'line_discount' => 0,
                    'line_total' => $qty * $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // 7) if paid immediately => stock out + transactions now
            if ($paymentStatus === 'paid') {
                $this->finalizePaidSale($saleId);
                return ['sale_id' => $saleId, 'qr' => null];
            }

            // 8) QR pending: generate placeholder payment_ref + qr_string (replace with real provider)
            $paymentRef = 'PROVIDER_REF_' . $saleId; // should come from provider
            $qrString = "QR_PAYLOAD_FOR_$saleId";     // should come from provider

            DB::table('sales')->where('id', $saleId)->update([
                'payment_ref' => $paymentRef,
                'updated_at' => now(),
            ]);

            return ['sale_id' => $saleId, 'qr' => $qrString];
        });

        // QR => show QR page
        if ($paymentType === 'qr') {
            return view('admin.pos_qr', [
                'saleId' => $result['sale_id'],
                'qrString' => $result['qr'],
            ]);
        }

        // cash/card => receipt
        return redirect()->route('admin.pos.receipt', $result['sale_id']);
    }

    // ✅ receipt MUST exist
    public function receipt($saleId)
    {
        $sale = DB::table('sales')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->leftJoin('customers', 'customers.id', '=', 'sales.customer_id')
            ->where('sales.id', $saleId)
            ->select(
                'sales.*',
                'users.name as cashier_name',
                DB::raw("COALESCE(customers.name, '-') as customer_name")
            )
            ->first();

        abort_if(!$sale, 404);

        $items = DB::table('sale_items')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->where('sale_items.sale_id', $saleId)
            ->select(
                'products.name',
                'products.image_path',
                'sale_items.qty',
                'sale_items.price',
                'sale_items.line_total'
            )
            ->get();

        return view('admin.pos_receipt', compact('sale', 'items'));
    }

    /**
     * ✅ PUBLIC (so webhook/admin verify can call it)
     * Finalize paid sale: decrement stock + insert stock out transactions + mark sale paid
     */
    public function finalizePaidSale(int $saleId): void
    {
        DB::transaction(function () use ($saleId) {

            $sale = DB::table('sales')->where('id', $saleId)->lockForUpdate()->first();
            if (!$sale)
                throw new \Exception("Sale not found");

            // prevent double finalize
            if (($sale->payment_status ?? '') === 'paid') {
                return;
            }

            $items = DB::table('sale_items')->where('sale_id', $saleId)->get();

            foreach ($items as $it) {
                $p = DB::table('products')->where('id', $it->product_id)->lockForUpdate()->first();
                if (!$p)
                    throw new \Exception("Product missing");
                if ((int) $it->qty > (int) $p->stock) {
                    throw new \Exception("Not enough stock for {$p->name}");
                }

                DB::table('products')
                    ->where('id', $it->product_id)
                    ->decrement('stock', (int) $it->qty);

                DB::table('transactions')->insert([
                    'product_id' => $it->product_id,
                    'user_id' => $sale->user_id,
                    'type' => 'out',
                    'qty' => (int) $it->qty,
                    'reference_id' => $saleId,
                    'note' => 'POS Sale (Paid)',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('sales')->where('id', $saleId)->update([
                'payment_status' => 'paid',
                'paid_at' => now(),
                'updated_at' => now(),
            ]);
        });
    }
    public function paymentStatus($saleId)
    {
        $sale = DB::table('sales')->where('id', $saleId)->first();
        abort_if(!$sale, 404);

        return response()->json([
            'payment_status' => $sale->payment_status,
            'paid_at' => $sale->paid_at,
        ]);
    }
    public function store(Request $request)
    {
        // cash/card will come here (from admin.pos.store)
        // we reuse the same logic inside checkout()
        return $this->checkout($request);
    }


}