<?php

// App\Http\Controllers\Admin\PromotionController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = DB::table('promotions')
            ->leftJoin('products', 'products.id', '=', 'promotions.product_id')
            ->select('promotions.*', 'products.name as product_name')
            ->orderByDesc('promotions.id')
            ->get();

        $products = DB::table('products')->select('id', 'name', 'sku')->orderBy('name')->get();

        return view('admin.promotions.index', compact('promotions', 'products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'nullable|integer|exists:products,id',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
        ]);

        // auto name (optional)
        $promoName = 'General Promotion';
        if (!empty($data['product_id'])) {
            $p = DB::table('products')->where('id', $data['product_id'])->first();
            $promoName = $p ? ('Promo - ' . $p->name) : $promoName;
        }

        DB::table('promotions')->insert([
            'product_id' => $data['product_id'] ?? null,
            'name' => $promoName,
            'type' => $data['type'],
            'value' => $data['value'],
            'min_amount' => $data['min_amount'] ?? 0,
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Promotion added');
    }

    public function toggle($id)
    {
        $promo = DB::table('promotions')->where('id', $id)->first();
        abort_if(!$promo, 404);

        DB::table('promotions')->where('id', $id)->update([
            'is_active' => $promo->is_active ? 0 : 1,
            'updated_at' => now(),
        ]);

        return back();
    }

    public function destroy($id)
    {
        DB::table('promotions')->where('id', $id)->delete();
        return back()->with('success', 'Promotion deleted');
    }
}