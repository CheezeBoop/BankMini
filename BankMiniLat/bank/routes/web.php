<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TellerController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function(){
  // common dashboard
  Route::get('/home',[DashboardController::class,'index'])->name('home');

  // Nasabah actions (login user role)
  Route::post('/deposit',[TransactionController::class,'requestDeposit'])->name('deposit.request');
  Route::post('/withdraw',[TransactionController::class,'requestWithdraw'])->name('withdraw.request');
});

// Teller routes
Route::middleware(['auth','role:teller'])->prefix('teller')->group(function(){
  Route::get('/dashboard',[TellerController::class,'dashboard'])->name('teller.dashboard');
  Route::get('/nasabah/create',[TellerController::class,'createNasabahForm'])->name('teller.nasabah.create');
  Route::post('/nasabah',[TellerController::class,'storeNasabah'])->name('teller.nasabah.store');
  Route::post('/transaksi/{id}/confirm',[TellerController::class,'confirmTransaction'])->name('teller.transaksi.confirm');
  Route::post('/nasabah/{id}/toggle',[TellerController::class,'toggleNasabahStatus'])->name('teller.nasabah.toggle');
  Route::get('/nasabah/{id}/print',[TellerController::class,'printNasabahTransaksi'])->name('teller.nasabah.print');
});

// Admin routes
Route::middleware(['auth','role:admin'])->prefix('admin')->group(function(){
  Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
  Route::get('/teller/create',[AdminController::class,'createTellerForm'])->name('admin.teller.create');
  Route::post('/teller',[AdminController::class,'storeTeller'])->name('admin.teller.store');
  Route::delete('/teller/{id}',[AdminController::class,'removeTeller'])->name('admin.teller.delete');
  Route::post('/transaksi/{id}/approve',[AdminController::class,'approveTransaction'])->name('admin.transaksi.approve');
});


require __DIR__.'/auth.php';
