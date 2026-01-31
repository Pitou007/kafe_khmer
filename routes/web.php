<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\AdminDashboardController;

use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PositionController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\PromotionController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\TransactionController;

use App\Http\Controllers\PaymentWebhookController;

// Home
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Logout
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// User dashboard
Route::get('/dashboard', fn() => view('dashboard'))->middleware('auth')->name('dashboard');


// ✅ PUBLIC webhook (bank callback) — NO auth/admin
Route::post('/payments/webhook', [PaymentWebhookController::class, 'handle'])
    ->name('payments.webhook');

// ✅ ADMIN AREA
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Admin profile
        Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        // POS
        Route::get('/pos', [PosController::class, 'create'])->name('pos');
        Route::post('/pos', [PosController::class, 'store'])->name('pos.store');
        Route::get('/pos/receipt/{sale}', [PosController::class, 'receipt'])->name('pos.receipt');

        // QR flow (pending + QR)
        Route::post('/pos/checkout', [PosController::class, 'checkout'])->name('pos.checkout');
        Route::get('/pos/payment-status/{sale}', [PosController::class, 'paymentStatus'])->name('pos.payment_status');
       
        // Sales
        Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
        Route::get('/sales/{id}', [SalesController::class, 'show'])->name('sales.show');
        Route::post('/sales/{id}/verify-payment', [SalesController::class, 'verifyPayment'])->name('sales.verifyPayment');

        // Promotions
        Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
        Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
        Route::post('/promotions/{id}/toggle', [PromotionController::class, 'toggle'])->name('promotions.toggle');
        Route::post('/promotions/{id}/delete', [PromotionController::class, 'destroy'])->name('promotions.delete');

        // Products CRUD
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::post('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::post('/products/{id}/delete', [ProductController::class, 'destroy'])->name('products.delete');

        // Customers
        Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
        Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
        Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
        Route::post('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
        Route::post('/customers/{id}/delete', [CustomerController::class, 'destroy'])->name('customers.delete');
        // Employee 
        // Employees
        Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/employees/{id}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::post('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::post('/employees/{id}/delete', [EmployeeController::class, 'destroy'])->name('employees.delete');

        // Suppliers
        Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::post('/suppliers/{id}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::post('/suppliers/{id}/delete', [SupplierController::class, 'destroy'])->name('suppliers.delete');

        // Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
        Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');

        // Categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
        Route::post('/categories/{id}/delete', [CategoryController::class, 'destroy'])->name('categories.delete');

        // Positions
        Route::get('/positions', [PositionController::class, 'index'])->name('positions.index');
        Route::get('/positions/create', [PositionController::class, 'create'])->name('positions.create');
        Route::post('/positions', [PositionController::class, 'store'])->name('positions.store');
        Route::get('/positions/{id}/edit', [PositionController::class, 'edit'])->name('positions.edit');
        Route::post('/positions/{id}', [PositionController::class, 'update'])->name('positions.update');
        Route::post('/positions/{id}/delete', [PositionController::class, 'destroy'])->name('positions.delete');

        // Reports
        Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('/reports/stock', [ReportController::class, 'stock'])->name('reports.stock');
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');

        // Transactions module
        Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('/transactions/stock-in', [TransactionController::class, 'createIn'])->name('transactions.in');
        Route::post('/transactions/stock-in', [TransactionController::class, 'storeIn'])->name('transactions.in.store');

        Route::get('/transactions/stock-out', [TransactionController::class, 'createOut'])->name('transactions.out');
        Route::post('/transactions/stock-out', [TransactionController::class, 'storeOut'])->name('transactions.out.store');

        Route::get('/transactions/broken', [TransactionController::class, 'createBroken'])->name('transactions.broken');
        Route::post('/transactions/broken', [TransactionController::class, 'storeBroken'])->name('transactions.broken.store');

        Route::get('/transactions/transfer', [TransactionController::class, 'createTransfer'])->name('transactions.transfer');
        Route::post('/transactions/transfer', [TransactionController::class, 'storeTransfer'])->name('transactions.transfer.store');
    });

// Reset password
Route::get('/forgot-password', fn() => view('auth.forgot-password'))
    ->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);
    $status = Password::sendResetLink($request->only('email'));
    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');
