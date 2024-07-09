<?php

namespace App\Http\Controllers;

use App\Http\Requests\BarangFormRequest;
use App\Models\Barang;
use App\Models\satuan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BarangController extends Controller
{
    public function get_barang()
    {
        $search = request("s");
        if ($search == "") {
            $data = Barang::with('satuan')->paginate(10);
        } else {
            $data =Barang::where('nama_barang', 'LIKE', '%' . $search. '%')->with('satuan')->paginate(10);
        }
        return response($data, Response::HTTP_OK);
    }

    public function detail_barang($id)
    {
        $data = Barang::where('$id', $id)->with('satuan')->first();
        $result = [
            'message' => 'Success',
            'error' => 'False',
            'data' => $data
        ];
        return response($result, Response::HTTP_OK);
    }

    public function store_barang(BarangFormRequest $request)
    {
        $field = $request->validated();
        //$field['img_url'] = asset('storage/' .$request->file('image', 'public'));
        $field['img_url'] = "https://upload.wikimedia.org/wikipedia/commons/3/3f/Placeholder_view_vector.svg";
        $data = Barang::create($field);

        foreach($request->satuan as $single){
            satuan::create([
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

    public function update_barang(BarangFormRequest $request,$id)
    {
        $field = $request->validated();
        //$field['img_url'] = asset($request->file('image')->store('image'));
        Barang::find($id)->update($field);
        $result = [
            'message' => 'Success',
            'error' => 'False'
        ];
        return response($result, Response::HTTP_OK);
    }
}
        

