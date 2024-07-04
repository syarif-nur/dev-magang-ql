<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('index', [BarangController::class, 'index'])->name('barang.index');
Route::get('list-barang/', [BarangController::class, 'get_barang'])->name('barang.get');
Route::get('detail-barang/{id}', [BarangController::class, 'detail_barang'])->name('detail.get');
Route::post('store-barang', [BarangController::class, 'store_barang'])->name('barang.store');
Route::get('transaksi/{id}', [TransaksiController::class, 'get_transaksi'])->name('transaksi.get');
Route::put('update-barang/{id}', [BarangController::class, 'update_barang'])->name('barang.update');
Route::put('update-barang-satuan/{id}', [BarangController::class, 'update_barang_satuan'])->name('barangsatuan.update');
