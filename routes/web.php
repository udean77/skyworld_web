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
    return redirect()->route('login');
})->name('landing');

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

// Admin routes (hanya untuk admin)
Route::middleware(['auth', 'admin'])->group(function () {

    // Rute CRUD wahana (admin hanya bisa akses)
    Route::resource('wahana', WahanaController::class)->except(['index']);
    // Route users di sini dihapus agar tidak bentrok
});

// Rute untuk transaksi
Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::resource('transaksis', App\Http\Controllers\TransaksiController::class)->except(['create', 'store']);
    Route::get('pesan-tiket', [App\Http\Controllers\TransaksiController::class, 'create'])->name('transaksis.create');
    Route::post('pesan-tiket', [App\Http\Controllers\TransaksiController::class, 'store'])->name('transaksis.store');
    // Route resource transaksis bisa ditambah jika ingin fitur CRUD penuh
});
