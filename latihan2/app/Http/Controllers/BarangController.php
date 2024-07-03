<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangFormRequest;
use App\Models\Barang;
use App\Models\satuan_barang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Validator;


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

    public function store_barang(BarangFormRequest $request){
        $field = $request->validated();
        // $field['img_url'] = asset('storage/' .$request->file('image')->store('images', 'public'));
        $field['img_url'] = "https://i.kym-cdn.com/photos/images/newsfeed/002/738/959/060.gif";
        $data = Barang::create($field);
        // if(!$data){
        //     return 'error';
        // }
        foreach ($request -> satuan as $single){
            satuan_barang::create([
                'id_barang' => $data['id'],
                'nama_satuan' => $single['nama_satuan'],
                'harga' => $single['harga'],
            ]);
        }
        $result = [
            'message' => 'Success',
            'error' => 'False'
        ];
        return response($result, Response::HTTP_CREATED);
    }
}
