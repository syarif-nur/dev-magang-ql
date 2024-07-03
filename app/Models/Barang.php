<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use illuminate\Database\Eloquent\Relations\HasMany;
use PhpParser\Node\Stmt\Break_;

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
                return 'Non Active';
                break;
            default:
                return 'default';
                break;
    }
}
}
