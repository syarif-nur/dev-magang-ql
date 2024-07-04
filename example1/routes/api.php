<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\SatuanController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('list-barang',[BarangController::class,'get_barang']);
Route::get('detail-barang/{id}',[BarangController::class,'detail_barang']);
Route::post('store-barang',[BarangController::class,'storebarang']);
Route::get('satuan-barang',[SatuanController::class,'satuanbarang']);
Route::post('tambahsatuan',[SatuanController::class,'tambahsatuan']);
// Route::put('ubahbarang/{id}',[BarangController::class,'update_barang_satuan']);
Route::put('ubahbarang/{id}',[BarangController::class,'ubahbarang']);
