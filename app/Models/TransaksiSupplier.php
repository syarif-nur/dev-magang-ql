<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiSupplier extends Model
{
    use HasFactory;

    protected $table = 'transaksi_supplier';
    protected $fillable = ['barang_id', 'satuan_id', 'company_id', 'transaction_date', 'amount', 'transaction_type', 'description', 'status'];

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
    public function barang() {
        return $this->hasMany(Barang::class, 'barang_id', 'id');
    }
    public function satuan() {
        return $this->belongsTo(Satuan::class);

    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
