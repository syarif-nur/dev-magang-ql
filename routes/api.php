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

