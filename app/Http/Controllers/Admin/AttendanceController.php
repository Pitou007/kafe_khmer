<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    // Mark attendance page
    public function index(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $employees = DB::table('employees')
            ->join('positions', 'positions.id', '=', 'employees.position_id')
            ->select('employees.*', 'positions.name as position_name')
            ->orderBy('employees.name')
            ->get();

        $attendanceMap = DB::table('attendances')
            ->where('date', $date)
            ->get()
            ->keyBy('employee_id');

        return view('admin.attendance.index', compact('employees', 'attendanceMap', 'date'));
    }

    // Save attendance (bulk)
    public function store(Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'rows' => 'required|array',
            'rows.*.employee_id' => 'required|exists:employees,id',
            'rows.*.status' => 'required|in:Present,Late,Permission',
            'rows.*.check_in' => 'nullable',
            'rows.*.check_out' => 'nullable',
        ]);

        DB::transaction(function () use ($data) {
            foreach ($data['rows'] as $r) {
                DB::table('attendances')->updateOrInsert(
                    [
                        'employee_id' => $r['employee_id'],
                        'date' => $data['date'],
                    ],
                    [
                        'status' => $r['status'],
                        'check_in' => $r['check_in'] ?: null,
                        'check_out' => $r['check_out'] ?: null,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            }
        });

        return redirect()->route('admin.attendance.index', ['date' => $data['date']])
            ->with('success', 'Attendance saved');
    }

    // Report
    public function report(Request $request)
    {
        $from = $request->get('from', now()->startOfMonth()->toDateString());
        $to   = $request->get('to', now()->toDateString());

        $rows = DB::table('attendances')
            ->join('employees', 'employees.id', '=', 'attendances.employee_id')
            ->whereBetween('attendances.date', [$from, $to])
            ->select(
                'employees.id',
                'employees.name',
                DB::raw("SUM(attendances.status='Present') as present_count"),
                DB::raw("SUM(attendances.status='Late') as late_count"),
                DB::raw("SUM(attendances.status='Permission') as permission_count")
            )
            ->groupBy('employees.id', 'employees.name')
            ->orderBy('employees.name')
            ->get();

        return view('admin.attendance.report', compact('rows', 'from', 'to'));
    }
}