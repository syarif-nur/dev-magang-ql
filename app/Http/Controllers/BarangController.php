<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BarangController extends Controller
{
   public function index()
    {
        $data = [
            "message" => "Succes",
            "Error" => false,
            'data' => [
                'nama_barang' => 'buku',
                'qty' => '10'
            ]
            ];
            return response($data, Response:: HTTP_OK);
    }
}
