<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WahanaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

// Auth routes
Auth::routes();
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('wahana', WahanaController::class)->except(['index']);
});

// Rute halaman landing atau beranda
Route::get('/', function () {
    return view('home'); // Ganti sesuai kebutuhan
})->name('landing');

// Rute yang memerlukan login (auth)
Route::middleware(['auth'])->group(function () {

    // Rute dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk melihat wahana (hanya setelah login)
    Route::get('/wahana', [WahanaController::class, 'index'])->name('wahana.index');
});

// Admin routes (hanya untuk admin)
Route::middleware(['auth', 'admin'])->group(function () {

    // Rute CRUD wahana (admin hanya bisa akses)
    Route::resource('wahana', WahanaController::class)->except(['index']);

    // Rute CRUD user (admin hanya bisa akses)
    Route::resource('users', UserController::class);
});
