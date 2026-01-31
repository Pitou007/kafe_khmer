<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // List (history)
    public function index(Request $request)
    {
        $type = $request->get('type', 'all');

        $txns = DB::table('transactions')
            ->join('products', 'products.id', '=', 'transactions.product_id')
            ->leftJoin('users', 'users.id', '=', 'transactions.user_id')
            ->when($type !== 'all', fn($q) => $q->where('transactions.type', $type))
            ->select(
                'transactions.*',
                'products.name as product_name',
                'products.sku as product_sku',
                'users.name as user_name'
            )
            ->orderByDesc('transactions.id')
            ->get();

        return view('admin.transactions.index', compact('txns', 'type'));
    }

    // ---------- STOCK IN ----------
    public function createIn()
    {
        $products = DB::table('products')->select('id','name','sku','stock')->orderBy('name')->get();
        return view('admin.transactions.stock_in', compact('products'));
    }

    public function storeIn(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'note' => ['nullable','string','max:255'],
        ]);

        DB::transaction(function () use ($data) {
            DB::table('transactions')->insert([
                'product_id' => $data['product_id'],
                'user_id' => auth()->id(),
                'type' => 'in',
                'qty' => (int)$data['qty'],
                'reference_id' => null,
                'note' => $data['note'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('products')->where('id', $data['product_id'])->increment('stock', (int)$data['qty']);
        });

        return back()->with('success', 'Stock IN saved ✅');
    }

    // ---------- STOCK OUT ----------
    public function createOut()
    {
        $products = DB::table('products')->select('id','name','sku','stock')->orderBy('name')->get();
        return view('admin.transactions.stock_out', compact('products'));
    }

    public function storeOut(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'note' => ['nullable','string','max:255'],
        ]);

        DB::transaction(function () use ($data) {
            // lock row to prevent negative stock
            $p = DB::table('products')->where('id', $data['product_id'])->lockForUpdate()->first();
            if ((int)$data['qty'] > (int)$p->stock) {
                throw new \Exception("Not enough stock for {$p->name}");
            }

            DB::table('transactions')->insert([
                'product_id' => $data['product_id'],
                'user_id' => auth()->id(),
                'type' => 'out',
                'qty' => (int)$data['qty'],
                'reference_id' => null,
                'note' => $data['note'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('products')->where('id', $data['product_id'])->decrement('stock', (int)$data['qty']);
        });

        return back()->with('success', 'Stock OUT saved ✅');
    }

    // ---------- BROKEN ----------
    public function createBroken()
    {
        $products = DB::table('products')->select('id','name','sku','stock')->orderBy('name')->get();
        return view('admin.transactions.broken', compact('products'));
    }

    public function storeBroken(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'note' => ['nullable','string','max:255'], // reason: expired/broken...
        ]);

        DB::transaction(function () use ($data) {
            $p = DB::table('products')->where('id', $data['product_id'])->lockForUpdate()->first();
            if ((int)$data['qty'] > (int)$p->stock) {
                throw new \Exception("Not enough stock for {$p->name}");
            }

            DB::table('transactions')->insert([
                'product_id' => $data['product_id'],
                'user_id' => auth()->id(),
                'type' => 'broken',
                'qty' => (int)$data['qty'],
                'reference_id' => null,
                'note' => $data['note'] ?? 'broken',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('products')->where('id', $data['product_id'])->decrement('stock', (int)$data['qty']);
        });

        return back()->with('success', 'Broken stock saved ✅');
    }

    // ---------- TRANSFER (basic version without locations) ----------
    public function createTransfer()
    {
        $products = DB::table('products')->select('id','name','sku','stock')->orderBy('name')->get();
        return view('admin.transactions.transfer', compact('products'));
    }

    public function storeTransfer(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['required','integer','min:1'],
            'note' => ['nullable','string','max:255'], // to where?
        ]);

        DB::transaction(function () use ($data) {
            $p = DB::table('products')->where('id', $data['product_id'])->lockForUpdate()->first();
            if ((int)$data['qty'] > (int)$p->stock) {
                throw new \Exception("Not enough stock for {$p->name}");
            }

            DB::table('transactions')->insert([
                'product_id' => $data['product_id'],
                'user_id' => auth()->id(),
                'type' => 'transfer',
                'qty' => (int)$data['qty'],
                'reference_id' => null,
                'note' => $data['note'] ?? 'transfer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // until you have locations, transfer reduces current stock
            DB::table('products')->where('id', $data['product_id'])->decrement('stock', (int)$data['qty']);
        });

        return back()->with('success', 'Transfer saved ✅');
    }
}