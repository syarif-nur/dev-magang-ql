<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'id_barang',
        'id_satuan',
        'qty',
        'total_harga',
        'status'
    ];

    public function barang(){
        return $this->hasMany(Barang::class,'id','id_barang');
    }

    public function satuan(){
        return $this->hasMany(satuan_barang::class,'id','id_satuan');
    }
}
