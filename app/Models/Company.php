<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use illuminate\Database\Eloquent\Relation\hasMany;

class Company extends Model
{
   use HasFactory;

    protected $table = 'company';
    protected $fillable = ['supplier_id', 'company_name', 'address', 'city', 'state', 'postal_code', 'country', 'phone_number', 'website'];

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
   public function supplier(){
    return $this->hasMany(Supplier::class, 'supplier_id', 'id');
   }
}
