<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satuan extends Model
{
    use HasFactory;
    protected $table = 'satuan_barang';
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
}
