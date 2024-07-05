<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'supplier';
    protected $fillable = ['firstname','lastname','email','phone'];

    public function supplierAddress(){
        return $this->hasMany(SupplierAddress::class,'supplier_id','id');
    }

    public function company(){
        return $this->hasMany(Company::class,'supplier_id','id');
    }
}
