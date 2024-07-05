<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $table = 'company';
    protected $fillable = ['supplier_id','company_name','address','city','state','postal_code','country','phone_number','website'];

    public function supplier(){
        return $this->belongsTo(Supplier::class,'supplier_id','id');
    }

    public function transaksiSupplier(){
        return $this->hasMany(TransaksiSupplier::class,'company_id','id');
    }
}
