<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransaksiController extends Controller
{
    public function get_transaksi($id)
    {
        $transaksi = Transaksi::where("id", $id)->with("barang")->with("satuan")->first();

        $result = [
            "Message" => "Success",
            "error" => false,
            "transaksi" => $transaksi
        ];

        return response($result, Response::HTTP_OK);
    }
}
