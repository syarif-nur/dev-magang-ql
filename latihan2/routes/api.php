<?php

use App\Http\Controllers\BarangController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

// barang

Route::get('list-barang/', [BarangController::class, 'get_barang'])->name('barang.get');
Route::get('detail-barang/{id}', [BarangController::class, 'detail_barang'])->name('detail.get');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
