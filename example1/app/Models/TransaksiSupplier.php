<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSupplier extends Model
{
    use HasFactory;

    protected $table =  'transaksi_supplier';
    protected $fillable = ['barang_id','satuan_id','company_id','transaction_date','amount','transaction_type','description'];

    public function barang(){
        return $this->belongsTo(Barang::class,'barang_id','id');
    }

    public function satuan(){
        return $this->belongsTo(Satuan::class,'satuan_id','id');
    }

    public function company(){
        return $this->belongsTo(Company::class,'company_id','id');
    }
}
