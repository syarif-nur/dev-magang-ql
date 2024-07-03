<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = ['id_barang','id_satuan','qty', 'total_harga', 'status'];
    public static function status($i)
    {
        switch ($i) {
            case 1:
                return 'Active';
                break;
            case 2:
                return  'Non Active';
                break;
            case 3:
                return 'default';
                break;
        }
    }

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'id_barang');
    }

    public function satuan()
    {
        return $this->hasOne(Satuan::class, 'id', 'id_satuan');
    }
}
