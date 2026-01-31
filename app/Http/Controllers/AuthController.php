<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ==========Login Controller============
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // ✅ STATIC ADMIN LOGIN (from .env)
        $adminEmail = env('ADMIN_EMAIL');
        $adminPass = env('ADMIN_PASSWORD'); // can be plain or hashed

        if ($adminEmail && $adminPass && $credentials['email'] === $adminEmail) {
            $plainInput = $credentials['password'];

            // Support BOTH: plain env OR hashed env
            $isHashed = str_starts_with($adminPass, '$2y$') || str_starts_with($adminPass, '$argon2');
            $ok = $isHashed ? Hash::check($plainInput, $adminPass) : ($plainInput === $adminPass);

            if ($ok) {
                $request->session()->regenerate();
                session([
                    'is_admin' => true,
                    'admin_email' => $adminEmail,
                    'admin_name' => 'Admin',
                ]);

                return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
            }
        }

        // ✅ Normal users login (DATABASE)
        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $role = Auth::user()->role ?? 'cashier';

            return match ($role) {
                'admin' => redirect()->route('admin.dashboard')->with('success', 'Welcome back!'),
                'cashier' => redirect()->route('dashboard')->with('success', 'Welcome back!'),
                'staff' => redirect()->route('dashboard')->with('success', 'Welcome back!'),
                default => redirect()->route('dashboard')->with('success', 'Welcome back!'),
            };
        }

        // ✅ For toast (session('error')) + keep email
        return back()
            ->with('error', 'Email or password is incorrect.')
            ->onlyInput('email');
    }

    // ==========Register Controller============
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cashier', // default role
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Account created successfully!');
    }

    // (optional) logout
    public function logout(Request $request)
    {
        Auth::logout();

        // also clear your admin session flags
        $request->session()->forget(['is_admin', 'admin_email', 'admin_name']);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out.');
    }
}