<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\AngsuranController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    // return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::resource('dashboard', DashboardController::class);
    Route::resource('anggota', AnggotaController::class);
    Route::get('api/anggota/search', [AnggotaController::class, 'search'])->name('api.anggota.search');
    Route::resource('simpanan', SimpananController::class);
    Route::get('simpanan/{simpanan}/print', [SimpananController::class, 'print'])->name('simpanan.print');
    Route::resource('pinjaman', PinjamanController::class);
    Route::resource('angsuran', AngsuranController::class);
    Route::get('api/pinjaman/search', [PinjamanController::class, 'search'])->name('api.pinjaman.search');
});

// use App\Http\Controllers\AnggotaController;
// use App\Http\Controllers\SimpananController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified',
// ])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');
// });

// Route::resource('dashboard', Dashboard::class);
// Route::resource('anggota', AnggotaController::class);
// Route::resource('simpanan', SimpananController::class);
