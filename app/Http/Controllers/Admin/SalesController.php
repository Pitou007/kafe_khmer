<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\PosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    // Sales list
    public function index()
    {
        $sales = DB::table('sales')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->leftJoin('customers', 'customers.id', '=', 'sales.customer_id')
            ->select(
                'sales.*',
                'users.name as cashier_name',
                DB::raw("COALESCE(customers.name, '-') as customer_name")
            )
            ->orderByDesc('sales.id')
            ->paginate(15);

        return view('admin.sales.index', compact('sales'));
    }

    // Sale detail
    public function show($id)
    {
        $sale = DB::table('sales')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->leftJoin('customers', 'customers.id', '=', 'sales.customer_id')
            ->where('sales.id', $id)
            ->select(
                'sales.*',
                'users.name as cashier_name',
                DB::raw("COALESCE(customers.name, '-') as customer_name")
            )
            ->first();

        abort_if(!$sale, 404);

        $items = DB::table('sale_items')
            ->join('products', 'products.id', '=', 'sale_items.product_id')
            ->where('sale_items.sale_id', $id)
            ->select(
                'products.name',
                'products.sku',
                'products.image_path',
                'sale_items.qty',
                'sale_items.price',
                'sale_items.line_discount',
                'sale_items.line_total'
            )
            ->get();

        return view('admin.sales.show', compact('sale', 'items'));
    }

    // Manual admin verify payment (mark paid + finalize)
    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'payment_ref' => ['nullable', 'string', 'max:255'],
        ]);

        $sale = DB::table('sales')->where('id', $id)->first();
        abort_if(!$sale, 404);

        // If already paid, just go receipt (avoid double stock out)
        if (($sale->payment_status ?? '') === 'paid') {
            return redirect()->route('admin.pos.receipt', $id)
                ->with('success', 'Already PAID.');
        }

        // Update sale status to PAID first
        DB::table('sales')->where('id', $id)->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'payment_ref' => $request->input('payment_ref') ?: ($sale->payment_ref ?? null),
            'updated_at' => now(),
        ]);

        // ✅ Finalize stock + transactions
        app(PosController::class)->finalizePaidSale((int) $id);

        return redirect()->route('admin.pos.receipt', $id)
            ->with('success', 'Payment marked as PAID.');
    }
}
