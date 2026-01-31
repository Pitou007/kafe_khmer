<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = DB::table('employees')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('employees.*', 'positions.name as position_name')
            ->orderByDesc('employees.id')
            ->get();

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $positions = DB::table('positions')->orderBy('name')->get();
        return view('admin.employees.create', compact('positions'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'start_date' => 'nullable|date',
        ]);

        DB::table('employees')->insert([
            'name' => $data['name'],
            'position_id' => $data['position_id'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee added');
    }

    public function edit($id)
    {
        $employee = DB::table('employees')->where('id', $id)->first();
        abort_if(!$employee, 404);

        $positions = DB::table('positions')->orderBy('name')->get();
        return view('admin.employees.edit', compact('employee', 'positions'));
    }

    public function update(Request $request, $id)
    {
        $employee = DB::table('employees')->where('id', $id)->first();
        abort_if(!$employee, 404);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position_id' => 'required|exists:positions,id',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'start_date' => 'nullable|date',
        ]);

        DB::table('employees')->where('id', $id)->update([
            'name' => $data['name'],
            'position_id' => $data['position_id'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated');
    }

    public function destroy($id)
    {
        DB::table('employees')->where('id', $id)->delete();
        return back()->with('success', 'Employee deleted');
    }
}