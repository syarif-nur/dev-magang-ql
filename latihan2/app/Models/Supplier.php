<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = ['firstname','lastname','email','phone',];

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

    public function supplierAddresses()
    {
        return $this->hasMany(Supplier_address::class, 'supplier_id', 'id');
    }

    public function companies()
    {
        return $this->hasMany(Company::class, 'supplier_id', 'id');
    }
}
