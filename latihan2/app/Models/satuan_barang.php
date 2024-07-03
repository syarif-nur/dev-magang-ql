<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satuan_barang extends Model
{
    use HasFactory;

    protected $table = 'satuan_barang';

    protected $fillable = ['nama_satuan','id_barang', 'harga', 'status'];

    public static function status($i){
        switch ($i){
            case 1:
                return 'Active';
                break;
            case 2:
                return 'Non Active';
                break;
            case 3:
                return 'default';
                break;
        }
    }
}
