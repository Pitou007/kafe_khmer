<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    // A) Sales report
    public function sales(Request $request)
    {
        $from = $request->get('from', now()->toDateString());
        $to = $request->get('to', now()->toDateString());

        $sales = DB::table('sales')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->whereDate('sales.created_at', '>=', $from)
            ->whereDate('sales.created_at', '<=', $to)
            ->select('sales.*', 'users.name as cashier_name')
            ->orderByDesc('sales.id')
            ->get();

        $summary = [
            'count' => $sales->count(),
            'subtotal' => (float) $sales->sum('total_amount'),
            'discount' => (float) $sales->sum('discount'),
            'tax' => (float) $sales->sum('tax'),
            'final' => (float) $sales->sum('final_total'),
        ];

        return view('admin.reports.sales', compact('sales', 'from', 'to', 'summary'));
    }

    // B) Stock report (current stock + value)
    public function stock(Request $request)
    {
        $q = trim($request->get('q', ''));

        $products = DB::table('products')
            ->when($q, function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%$q%")
                        ->orWhere('sku', 'like', "%$q%");
                });
            })
            ->select('id', 'name', 'sku', 'price', 'stock')
            ->orderBy('name')
            ->get();

        $totalItems = (int) $products->sum('stock');

        $estimatedValue = 0;
        foreach ($products as $p) {
            $estimatedValue += ((float) $p->price) * ((int) $p->stock);
        }

        return view('admin.reports.stock', compact('products', 'q', 'totalItems', 'estimatedValue'));
    }

    // C) Transaction report
    public function transactions(Request $request)
    {
        $type = $request->get('type', 'all');
        $from = $request->get('from', now()->subDays(7)->toDateString());
        $to = $request->get('to', now()->toDateString());

        $txns = DB::table('transactions')
            ->join('products', 'products.id', '=', 'transactions.product_id')
            ->leftJoin('users', 'users.id', '=', 'transactions.user_id')

            // ✅ join sales ONLY when type = out (because out is from POS sale)
            ->leftJoin('sales', function ($join) {
                $join->on('sales.id', '=', 'transactions.reference_id')
                    ->where('transactions.type', '=', 'out');
            })

            ->whereDate('transactions.created_at', '>=', $from)
            ->whereDate('transactions.created_at', '<=', $to)
            ->when($type !== 'all', fn($q) => $q->where('transactions.type', $type))
            ->select(
                'transactions.*',
                'products.name as product_name',
                'users.name as user_name',
                'sales.invoice_number'
            )
            ->orderByDesc('transactions.id')
            ->get();

        return view('admin.reports.transactions', compact('txns', 'type', 'from', 'to'));
    }




}