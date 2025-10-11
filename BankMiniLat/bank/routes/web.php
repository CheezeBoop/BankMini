+<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TellerController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Dashboard Redirect by Role
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Teller management
    Route::get('/teller/create', [AdminController::class, 'createTellerForm'])->name('admin.teller.create');
    Route::post('/teller/store',  [AdminController::class, 'storeTeller'])->name('admin.teller.store');
    Route::get('/teller/{id}/edit', [AdminController::class, 'editTeller'])->name('admin.teller.edit');        // ✅ NEW
    Route::put('/teller/{id}',      [AdminController::class, 'updateTeller'])->name('admin.teller.update');     // ✅ NEW
    Route::delete('/teller/{id}', [AdminController::class, 'removeTeller'])->name('admin.teller.remove');

    // Approve transaksi
    Route::post('/transaksi/{id}/approve', [AdminController::class, 'approveTransaction'])
        ->name('admin.transaksi.approve');

    // Log kategori (akun, setor, tarik)
    Route::get('/log/{type}', [AdminController::class, 'logByType'])->name('admin.log.type');

    // Settings perusahaan  🔧 perbaiki path ganda /admin/admin/settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');    // ✅ FIX
    Route::post('/settings', [SettingsController::class, 'update'])->name('admin.settings.update');  // ✅ FIX

    Route::get('/logs/export', [AdminController::class, 'exportLogs'])->name('admin.logs.export');
});

/*
|--------------------------------------------------------------------------
| Teller Routes
|--------------------------------------------------------------------------
*/
Route::prefix('teller')->middleware(['auth', 'role:teller'])->group(function () {
    // Dashboard utama teller
    Route::get('/dashboard', [TellerController::class, 'dashboard'])->name('teller.dashboard');

    // Form buat nasabah baru (opsional bisa pake modal)
    Route::get('/nasabah/create', function () {
        return view('teller.create_nasabah');
    })->name('teller.nasabah.create');

    // Simpan nasabah baru
    Route::post('/nasabah/store', [TellerController::class, 'storeNasabah'])->name('teller.nasabah.store');

    // Transaksi setor & tarik
    Route::post('/rekening/{id}/setor', [TellerController::class, 'setor'])->name('teller.setor');
    Route::post('/rekening/{id}/tarik', [TellerController::class, 'tarik'])->name('teller.tarik');

    // Konfirmasi & tolak transaksi
    Route::post('/transaksi/{id}/confirm', [TellerController::class, 'confirmTransaksi'])->name('teller.transaksi.confirm');
    Route::post('/transaksi/{id}/reject', [TellerController::class, 'rejectTransaction'])->name('teller.transaksi.reject');

    // Edit profil nasabah
    Route::put('/nasabah/{id}/update', [TellerController::class, 'updateNasabah'])->name('teller.nasabah.update');
});

/*
|--------------------------------------------------------------------------
| Nasabah Routes
|--------------------------------------------------------------------------
*/
Route::prefix('nasabah')->middleware(['auth', 'role:nasabah'])->group(function () {
    // Dashboard & profil
    Route::get('/dashboard', [NasabahController::class, 'dashboard'])->name('nasabah.dashboard');
    Route::get('/profile',   [NasabahController::class, 'profile'])->name('nasabah.profile');

    // Proses request (POST) - langsung di NasabahController
    Route::post('/deposit/request',  [NasabahController::class, 'requestDeposit'])
        ->name('nasabah.deposit.request');
    Route::post('/withdraw/request', [NasabahController::class, 'requestWithdraw'])
        ->name('nasabah.withdraw.request');
});


Route::get('/layanan', function () {
    return view('layanan'); // resources/views/layanan.blade.php
})->name('layanan');