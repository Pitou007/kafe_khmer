<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PositionController extends Controller
{
    public function index()
    {
        $positions = DB::table('positions')->orderByDesc('id')->get();
        return view('admin.positions.index', compact('positions'));
    }

    public function create()
    {
        return view('admin.positions.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name',
            'base_salary' => 'nullable|numeric|min:0',
        ]);

        DB::table('positions')->insert([
            'name' => $data['name'],
            'base_salary' => $data['base_salary'] ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.positions.index')->with('success', 'Position created');
    }

    public function edit($id)
    {
        $position = DB::table('positions')->where('id', $id)->first();
        abort_if(!$position, 404);

        return view('admin.positions.edit', compact('position'));
    }

    public function update(Request $request, $id)
    {
        $position = DB::table('positions')->where('id', $id)->first();
        abort_if(!$position, 404);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:positions,name,' . $id,
            'base_salary' => 'nullable|numeric|min:0',
        ]);

        DB::table('positions')->where('id', $id)->update([
            'name' => $data['name'],
            'base_salary' => $data['base_salary'] ?? 0,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.positions.index')->with('success', 'Position updated');
    }

    public function destroy($id)
    {
        // If employees FK exists, deleting position may fail unless you handle it.
        // Best: block delete if used by employees.
        $used = DB::table('employees')->where('position_id', $id)->exists();
        if ($used) {
            return back()->with('error', 'Cannot delete. Position is used by employees.');
        }

        DB::table('positions')->where('id', $id)->delete();
        return back()->with('success', 'Position deleted');
    }
}