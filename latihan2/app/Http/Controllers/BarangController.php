<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BarangController extends Controller
{
    public function get_barang(){
        return Barang::all();
        $search = request("s");
        if ($search == ""){
            $data = Barang::all();
        }else{
            $data = Barang::where('nama barang', 'LIKE', '%'.$search.'%')->with('satuan')->paginate(10);
        }return response($data, Response::HTTP_OK);
    }

    public function detail_barang($id){
        $data = Barang::where('id',$id)->width('satuan')->first();
        $result = [
            'message' => 'Success',
            'error'  => 'False',
            'data' => $data
        ];
        return response($result, Response::HTTP_OK);
    }
}
