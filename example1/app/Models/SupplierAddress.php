<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierAddress extends Model
{
    use HasFactory;
    protected $table = 'supplier_address';
    protected $fillable = ['supplier_id','address','city','state','zipcode','country'];

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

}
