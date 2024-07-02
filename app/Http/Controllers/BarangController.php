<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
}
