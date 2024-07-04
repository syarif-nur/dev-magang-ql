<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'master_barang';
    protected $fillable = ['nama_barang','img_url','status','qty'];

    public function satuan(){
        return $this->hasMany(Satuan::class,'id_barang','id');
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
