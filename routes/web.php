<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::resource('pelanggan', PelangganController::class);
Route::resource('barang', BarangController::class);
Route::resource('transaksi', TransaksiController::class);
Route::get('transaksi/rekap/laporan', [TransaksiController::class, 'rekap'])->name('transaksi.rekap');
