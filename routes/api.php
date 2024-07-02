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
