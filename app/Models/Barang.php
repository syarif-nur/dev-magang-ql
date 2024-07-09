<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'master_barang';
    protected $fillable = ['nama_barang', 'img_url', 'status', 'qty'];

    public static function status($i)
    {
        switch ($i) {
            case 1:
                return 'Active';
                break;
                case 2:
                    return 'non Active';
                    break;
                    default:
                    return 'default';
                    break;
        }
    }
    public function satuan(){
        return $this->hasMany(Satuan::class,'barang_id','id');
    }
    public function Transaksi_supplier(){
        return $this->belongsTo(Transaksi_supplier::class);
}
}
