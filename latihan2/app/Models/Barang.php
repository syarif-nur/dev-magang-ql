<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\satuan_barang;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'master_barang';

    protected $fillable = ['nama_barang', 'img_url', 'status'];

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

    public function satuan(){
        return $this->hasMany(satuan_barang::class,'id_barang','id');
    }
}
