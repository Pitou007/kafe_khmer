<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = DB::table('suppliers')->orderByDesc('id')->get();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        DB::table('suppliers')->insert([
            'name' => $data['name'],
            'company_name' => $data['company_name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'note' => $data['note'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier added');
    }

    public function edit($id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        abort_if(!$supplier, 404);

        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = DB::table('suppliers')->where('id', $id)->first();
        abort_if(!$supplier, 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'note' => 'nullable|string',
        ]);

        DB::table('suppliers')->where('id', $id)->update([
            'name' => $data['name'],
            'company_name' => $data['company_name'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'note' => $data['note'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier updated');
    }

    public function destroy($id)
    {
        DB::table('suppliers')->where('id', $id)->delete();
        return redirect()->route('admin.suppliers.index')->with('success', 'Supplier deleted');
    }
}