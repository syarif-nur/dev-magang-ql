<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\cusrtomertable;
use App\Http\Controllers\CustomerTableController;
use App\Http\Controllers\InventpryController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiTableController;
use App\Http\Controllers\ArithmeticController;
use Laravel\Sanctum\Sanctum;


Route::get('index-link', [BarangController::class, 'index'])->name('barang.index');



//barang
Route::get('list-barang', [BarangController::class, 'get_barang'])->name('barang.get');
Route::get('detail-barang/{d}', [BarangController::class, 'detail_barang'])->name('detail.get');
Route::post('store-barang', [BarangController::class, 'store_barang'])->name('barang.store');
Route::get('list-transaksi/', [BarangController::class,'get_transaksi'])->name('transaksi.get');
Route::put('update-barang/{id}', [BarangController::class, 'update_barang'])->name('barang.update');


//supplier
Route::get('daftar-supplier', [SupplierController::class, 'get_daftar'])->name('daftar.get');
Route::put('update-supplier/{id}', [SupplierController::class, 'update_supplier'])->name('supplier.update');
Route::post('add-supplier', [SupplierController::class,'addSupplier'])->name('supplier.add');
Route::get('/supplier/create', [SupplierController::class, 'create'])->name('supplier.create');
Route::delete('hapus-supplier/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
