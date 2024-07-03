<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\BarangFormRequest;

class BarangController extends Controller
{
    public function index()
    {
        $data = [
            "message" => "Success",
            "error" => false,
            "data" => [
                'nama_barang' => 'buku',
                'qty' => '10'
            ]
        ];
        return response($data, Response::HTTP_OK);
    }

    public function get_barang()
    {
        $search = request("s");
        if ($search == "") {
            $data = Barang::with("satuan")->paginate(10);
        } else {
            $data = Barang::where("nama_barang", "LIKE", "%" . $search . "%")->with("satuan")->paginate(10);
        }
        return response($data, Response::HTTP_OK);
    }

    public function detail_barang($id)
    {
        $data = Barang::where('id', $id)->with("satuan")->first();
        $result = [
            "message" => "Success",
            "error" => false,
            "data" => $data
        ];
        return response($result, Response::HTTP_OK);
    }

    public function store_barang(BarangFormRequest $request)
    {
        $field = $request->validated();
        // $field['img_url'] = asset('storage/' . $request->file('image')->store('images', 'public'));
        $field['img_url'] = "https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/2560px-Placeholder_view_vector.svg.png";
        $data = Barang::create($field);

        // if (!$data) {
        //     return 'error';
        // }
        foreach ($request->satuan as $single) {
            Satuan::create([
                'id_barang' => $data['id'],
                'nama_satuan' => $single['nama_satuan'],
                'harga' => $single['harga'],
            ]);
        }

        $result = [
            'message' => 'Success',
            'error' => 'False',
        ];
        return response($result, Response::HTTP_CREATED);
    }
}
