<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';

    protected $fillable = ['supplier_id','company_name','address','city','state','postal_code','country','phone_number','website'];

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

    public function transaksiSuppliers()
    {
        return $this->hasMany(Transaksi_supplier::class, 'company_id', 'id');
    }
}