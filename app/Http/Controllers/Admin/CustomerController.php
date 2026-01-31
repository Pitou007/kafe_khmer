<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')
            ->orderByDesc('id')
            ->get();

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.customers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'is_member' => 'nullable|boolean',
            'points' => 'nullable|integer|min:0',
        ]);

        DB::table('customers')->insert([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'is_member' => (bool)($data['is_member'] ?? 1),
            'points' => (int)($data['points'] ?? 0),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer added');
    }

    public function edit($id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        abort_if(!$customer, 404);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = DB::table('customers')->where('id', $id)->first();
        abort_if(!$customer, 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'is_member' => 'nullable|boolean',
            'points' => 'nullable|integer|min:0',
        ]);

        DB::table('customers')->where('id', $id)->update([
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'is_member' => (bool)($data['is_member'] ?? 1),
            'points' => (int)($data['points'] ?? 0),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated');
    }

    public function destroy($id)
    {
        DB::table('customers')->where('id', $id)->delete();
        return back()->with('success', 'Customer deleted');
    }
}