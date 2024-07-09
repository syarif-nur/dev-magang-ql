<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $fillable = ['firstname','lastname','email','phone'];

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

     public function supplieraddress(){
        return $this->hasMany(Supplier_address::class,'supplier_id','id');
    }

    public function TransaksiSupplier(){
        return $this->hasMany(Transaksi_supplier::class,'supplier_id','id');
    }
}
