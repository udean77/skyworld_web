<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WahanaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerTransaksiController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\TransaksiController;

// Auth routes
Auth::routes();
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('wahana', WahanaController::class)->except(['index']);
});

// Rute halaman landing atau beranda
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard'); // untuk admin/login biasa
    } elseif (session()->has('customer_id')) {
        return redirect()->route('customer.beranda'); // untuk customer yang login
    } else {
        return redirect('/login'); // kalau belum login
    }
});

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
    // Rute laporan
    Route::get('/transaksis/cetak', [TransaksiController::class, 'cetakLaporan'])->name('transaksis.cetak');
    Route::get('/transaksis/cetak-pdf', [TransaksiController::class, 'cetakPdf'])->name('transaksis.cetakPdf');
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
    Route::get('/transaksis/cetak', [TransaksiController::class, 'cetakLaporan'])->name('transaksis.cetak');
    Route::get('/transaksis/cetak-pdf', [TransaksiController::class, 'cetakPdf'])->name('transaksis.cetakPdf');
    Route::get('/transaksis/cetak-excel', [TransaksiController::class, 'cetakExcel'])->name('transaksis.cetak-excel');
});

// =====================
// ROUTE CUSTOMER (PENGUNJUNG)
// =====================

// Login Customer
Route::middleware('web')->group(function () {
    Route::get('/customer/login', [CustomerController::class, 'showLoginForm'])->name('customer.login');
    Route::post('/customer/login', [CustomerController::class, 'loginCustomer'])->name('customer.login.submit');
});
// Register Customer
Route::get('/customer/register', function () {
    return view('customer.register');
})->name('customer.register');
Route::post('/customer/register', [CustomerController::class, 'registerStore'])->name('customer.register.store');

// Beranda Customer (tanpa login pun bisa akses)
Route::get('/beranda', [CustomerController::class, 'beranda'])->name('customer.beranda');

// Halaman Detail Wahana
Route::get('/wahana/{id}/detail', function ($id) {
    $wahana = \App\Models\Wahana::findOrFail($id);
    return view('customer.wahana_detail', compact('wahana'));
})->name('customer.wahana.detail');

// =====================
// ROUTE KHUSUS CUSTOMER YANG LOGIN
// Middleware: auth.customer (custom middleware pakai session `customer_id`)
// =====================
Route::middleware(['auth.customer'])->group(function () {

    // Form pemesanan tiket
    Route::get('/customer/pesan-tiket', [CustomerTransaksiController::class, 'form'])->name('customer.pesan_tiket.form');
    Route::post('/customer/pesan-tiket', [CustomerTransaksiController::class, 'pesan'])->name('customer.transaksi.store');
    Route::get('/customer/{customer_id}/riwayat', [CustomerTransaksiController::class, 'riwayat'])->name('customer.riwayat.withid');
    Route::get('/customer/riwayat', [CustomerTransaksiController::class, 'riwayat'])->name('customer.riwayat');
    
    Route::get('/customer/transaksi/{id}/invoice', [CustomerTransaksiController::class, 'invoice'])->name('customer.transaksi.invoice');
    Route::get('/customer/transaksi/{id}/bayar', [CustomerTransaksiController::class, 'pembayaran'])->name('customer.transaksi.bayar');
    Route::get('/customer/transaksi/{id}/bayar', [CustomerTransaksiController::class, 'bayar'])->name('customer.transaksi.bayar');
    Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler']);


    // Logout customer
    Route::post('/customer/logout', function () {
        \Auth::logout();
        session()->forget('customer_id'); // optional, kalau kamu login customer pakai session
        return redirect()->route('customer.login');
    })->name('customer.logout');
});