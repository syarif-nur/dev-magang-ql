<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    use HasFactory;
    protected $table = 'supplier_addresses';
    protected $fillable = ['supplier_id', 'address', 'city', 'state', 'zipcode', 'country'];

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

    public function supplier(){
        return $this->hasOne(Supplier::class,'id','supplier_id');
    }
}
