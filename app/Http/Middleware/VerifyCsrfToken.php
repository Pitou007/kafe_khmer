<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    protected $except = [
        'payments/webhook',
    ];

    public function handle(Request $request, Closure $next)
    {
        // ✅ Allow webhook (and anything under it)
        if ($request->is('payments/webhook')) {
            return $next($request);
        }

        // ✅ Must be logged in
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // ✅ Must be admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Admin only');
        }

        return $next($request);
    }
}