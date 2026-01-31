<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $productsCount = DB::table('products')->count();
        $salesCount = DB::table('sales')->count();
        $usersCount = DB::table('users')->count();

        $todayRevenue = (float) DB::table('sales')
            ->whereDate('created_at', now()->toDateString())
            ->sum('final_total');

        $rows = DB::table('sales')
            ->selectRaw('DATE(created_at) as d, SUM(final_total) as total')
            ->whereDate('created_at', '>=', now()->subDays(6)->toDateString())
            ->groupBy('d')
            ->orderBy('d')
            ->get();

        $map = $rows->pluck('total', 'd')->toArray();

        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = Carbon::parse($date)->format('d M'); // 22 Jan
            $data[] = (float) ($map[$date] ?? 0);
        }

        return view('admin.dashboard', compact(
            'productsCount',
            'salesCount',
            'usersCount',
            'todayRevenue',
            'labels',
            'data'
        ));
    }
}