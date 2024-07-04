<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    use HasFactory;
    protected $table = 'satuan_barang';
    protected $fillable = ['id_barang','nama_satuan','harga','status'];

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang','id');
    }
    public static function status($i){
        switch ($i) {
            case 1:
                return 'Active';
                break;
            case 2:
                return 'Non Active';
                break;
            default:
                return 'default';
                break;
        }
    }
}
