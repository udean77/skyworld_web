<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WahanaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Auth routes
Auth::routes();
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('wahana', WahanaController::class)->except(['index']);
});

// Rute halaman landing atau beranda
Route::get('/', function () {
    return redirect()->route('customer.beranda');
})->name('home');

// Rute yang memerlukan login (auth)
Route::middleware(['auth'])->group(function () {

    // Rute dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk melihat wahana (hanya setelah login)
    Route::get('/wahana', [WahanaController::class, 'index'])->name('wahana.index');

    // Rute user management (bisa diakses semua role yang login)
    Route::resource('users', UserController::class);

    // Rute customer management
    Route::resource('customers', App\Http\Controllers\CustomerController::class);
});

// Admin routes (superadmin, admin, manager punya hak sama)
Route::middleware(['auth', 'admin'])->group(function () {
    // Rute CRUD wahana (admin hanya bisa akses)
    Route::resource('wahana', WahanaController::class)->except(['index']);
    // Route users di sini dihapus agar tidak bentrok
});

// Rute untuk transaksi
Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::resource('transaksis', App\Http\Controllers\TransaksiController::class)->except(['create', 'store']);
    Route::get('pesan-tiket', [App\Http\Controllers\TransaksiController::class, 'create'])->name('v_transaksi.create');
    Route::post('pesan-tiket', [App\Http\Controllers\TransaksiController::class, 'store'])->name('v_transaksi.store');
    // Route resource transaksis bisa ditambah jika ingin fitur CRUD penuh
});

// =====================
// ROUTE CUSTOMER (PENGUNJUNG)
// =====================
// Login customer
Route::get('/customer/login', function() {
    return view('customer.login');
})->name('customer.login');
Route::post('/customer/login', [App\Http\Controllers\CustomerController::class, 'loginCustomer'])->name('customer.login');

// Register customer
Route::get('/customer/register', function() {
    return view('customer.register');
})->name('customer.register');
Route::post('/customer/register', [App\Http\Controllers\CustomerController::class, 'registerStore'])->name('customer.register.store');

// Beranda customer
Route::get('/beranda', [App\Http\Controllers\CustomerController::class, 'beranda'])->name('customer.beranda');

Route::middleware(['auth', 'customer.only'])->group(function () {
    Route::get('/pesan-tiket', [App\Http\Controllers\CustomerTransaksiController::class, 'form'])->name('customer.pesan');
    Route::post('/pesan-tiket', [App\Http\Controllers\CustomerTransaksiController::class, 'pesan'])->name('customer.transaksi.store');
    Route::get('/customer/{id}/riwayat', [App\Http\Controllers\CustomerTransaksiController::class, 'riwayat'])->name('customer.riwayat');
    Route::get('/customer/logout', function() {
        \Auth::logout();
        return redirect()->route('customer.login');
    })->name('customer.logout');
    Route::get('/invoice/{id}', [App\Http\Controllers\CustomerTransaksiController::class, 'invoice'])->name('customer.invoice');
    Route::get('/riwayat-transaksi', [App\Http\Controllers\CustomerTransaksiController::class, 'riwayat'])->name('customer.riwayat');
});

// Halaman detail wahana untuk customer
Route::get('/wahana/{id}/detail', function($id) {
    $wahana = \App\Models\Wahana::findOrFail($id);
    return view('customer.wahana_detail', compact('wahana'));
})->name('customer.wahana.detail');

