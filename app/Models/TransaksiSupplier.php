<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiSupplier extends Model
{
    use HasFactory;

    protected $table = 'transaksi_suppliers';
    protected $fillable = [
        'barang_id', 'satuan_id', 'company_id', 'transaction_date', 'amount', 'transaction_type', 'description'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id', 'barang_id');
    }
    public function satuan()
    {
        return $this->hasMany(Satuan::class, 'id', 'satuan_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
