<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class TransaksiController extends Controller
{
    public function get_transaksi(){
        return Transaksi::all();
        $search = request("s");
        if ($search == ""){
            $data = Transaksi::all();
        }else{
            $data = Transaksi::where('nama barang', 'LIKE', '%'.$search.'%')->with('satuan')->paginate(10);
        }return response($data, Response::HTTP_OK);
    }
}
