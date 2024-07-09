<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

public function Barang(){
    return $this->belongsTo(Barang::class);
}
}

