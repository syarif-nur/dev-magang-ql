<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangFormRequest;
use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BarangController extends Controller
{
    public function get_barang(){
        $search = request("s");
        if($search == ""){
            $data = Barang::with('satuan')->paginate(10);
        }
        else{
            $data = Barang::where('nama_barang','LIKE','%',$search,'%')->with('satuan')->paginate(10);
        }
        return response($data,Response::HTTP_OK);
    }

    public function detail_barang($id){
        $data = Barang::where('id',$id)->with('satuan')->first();
        $result = [
            'message' => 'Success',
            'error' => 'false',
        ];
        return response($data,Response::HTTP_OK);
    }
    public function storebarang(BarangFormRequest $request){
        $field = $request->validated();
        $id = Barang::create([
            'nama_barang' => $request->nama_barang,
            'img_url' => asset('storage/' . $request->file('image')->store('images','public')),
            'status' => $request->status,
            'qty' => $request->qty
        ]);
        foreach($request->satuan as $sat){
            Satuan::create([
                'id_barang' => $id['id'],
                'harga' => $sat['harga'],
                'status' => $sat['status'],
            ]);
        }
        $result = [
            'message' => 'Success',
            'error' => 'false',
        ];
        return response($result,response::HTTP_CREATED);
    }
}
