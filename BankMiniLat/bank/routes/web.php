<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TellerController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\TransactionController;

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
    Route::post('/teller/store', [AdminController::class, 'storeTeller'])->name('admin.teller.store');
    Route::delete('/teller/{id}', [AdminController::class, 'removeTeller'])->name('admin.teller.remove');

    // Approve transaksi
    Route::post('/transaksi/{id}/approve', [AdminController::class, 'approveTransaction'])
        ->name('admin.transaksi.approve');

    // Log kategori (akun, setor, tarik) → untuk modal/pagination
    Route::get('/log/{type}', [AdminController::class, 'logByType'])->name('admin.log.type');
});

/*
|--------------------------------------------------------------------------
| Teller Routes
|--------------------------------------------------------------------------
*/
Route::prefix('teller')->middleware(['auth', 'role:teller'])->group(function () {
    Route::get('/dashboard', [TellerController::class, 'dashboard'])->name('teller.dashboard');

    // Form buat nasabah baru (opsional bisa pake modal)
    Route::get('/nasabah/create', function () {
        return view('teller.create_nasabah');
    })->name('teller.nasabah.create');

    // Simpan nasabah baru
    Route::post('/nasabah/store', [TellerController::class, 'storeNasabah'])->name('teller.nasabah.store');

    // Transaksi
    Route::post('/rekening/{id}/setor', [TellerController::class, 'setor'])->name('teller.setor');
    Route::post('/rekening/{id}/tarik', [TellerController::class, 'tarik'])->name('teller.tarik');
    Route::post('/transaksi/{id}/confirm', [TellerController::class, 'confirmTransaksi'])
        ->name('teller.transaksi.confirm');


    // edit profil nasabah
    Route::put('/nasabah/{id}/update', [TellerController::class, 'updateNasabah'])
    ->name('teller.nasabah.update');
});

/*
|--------------------------------------------------------------------------
| Nasabah Routes
|--------------------------------------------------------------------------
*/
Route::prefix('nasabah')->middleware(['auth', 'role:nasabah'])->group(function () {
    Route::get('/dashboard', [NasabahController::class, 'dashboard'])->name('nasabah.dashboard');

    // Request setor/tarik
    Route::post('/deposit/request', [TransactionController::class, 'requestDeposit'])
        ->name('nasabah.deposit.request');
    Route::post('/withdraw/request', [TransactionController::class, 'requestWithdraw'])
        ->name('nasabah.withdraw.request');
});
