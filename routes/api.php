<?php

use App\Http\Controllers\ArithmeticController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Customertable;
use App\Http\Controllers\CustomerTableController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\TransaksiTabeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('index-link', [BarangController::class, 'index'])->name('barang.index');

// Route::middleware ('auth:sanctum')->group(function)
// {
//     return $request->user();
// })->middleware('auth:sanctum');
//barang
Route::get('list-barang/', [BarangController::class, 'get_barang'])->name('barang.get');
Route::get('detail-barang/{id}', [BarangController::class, 'detail_barang'])->name('detail.get');
Route::post('store-barang', [BarangController::class, 'store_barang'])->name('barang.store');
Route::get('list-transaksi/', [TransaksiController::class, 'get_transaksi'])->name('transaksi.get');
Route::put('update-barang/{id}', [BarangController::class, 'update_barang'])->name('barang.update');

//supplier
Route::post('add-supplier', [SupplierController::class, 'add_supplier'])->name('supplier.add');
Route::get('/supplier/create', [SupplierController::class,'create'])->name('supplier.create');
Route::put('update-supplier/{id}', [SupplierController::class, 'update_supplier'])->name('supplier.update');
Route::delete('delete-supplier/{id}', [SupplierController::class,'delete_supplier'])->name('supplier.delete');
Route::get('/list-supplier', [SupplierController::class,'list_supplier'])->name('supplier.list');
