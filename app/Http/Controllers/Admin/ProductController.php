<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // LIST PRODUCTS
    public function index()
    {
        $products = DB::table('products')
            ->orderByDesc('id')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    // SHOW CREATE FORM
    public function create()
    {
        return view('admin.products.create');
    }

    // STORE NEW PRODUCT
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        DB::table('products')->insert([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image_path' => $imagePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    // SHOW EDIT FORM
    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        abort_if(!$product, 404);

        return view('admin.products.edit', compact('product'));
    }

    // UPDATE PRODUCT
    public function update(Request $request, $id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        abort_if(!$product, 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $product->image_path;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        DB::table('products')->where('id', $id)->update([
            'name' => $data['name'],
            'sku' => $data['sku'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image_path' => $imagePath,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully');
    }

    // DELETE PRODUCT
    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        abort_if(!$product, 404);

        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        DB::table('products')->where('id', $id)->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}