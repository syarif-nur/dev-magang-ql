<?php

namespace App\Http\Controllers;

use App\Http\Requests\SatuanFormRequest;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SatuanController extends Controller
{
    public function satuanbarang(){
        $satuan = Satuan::with('barang')->get();
        return response($satuan,Response::HTTP_OK);
    }
    public function tambahsatuan(SatuanFormRequest $request){
        $field = $request->validated();
        Satuan::create([
            'id_barang' => $request->id_barang,
            'harga' => $request->harga,
            'status' => $request->status
        ]);
        $result = [
            'message' => 'success',
            'error' => 'false',
        ];
        return response($result,Response::HTTP_CREATED);
    }
}
