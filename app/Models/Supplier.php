<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $fillable = ['firstname', 'lastname', 'email', 'phone', 'status'];

    public static function status($i)
    {
        switch ($i) {
        case 1;
            return 'Active';
            break;
        case 2;
            return 'Non Active';
            break;
        default;
            return 'default';
         break;
    }
}

    public function supplieraddress() {
        return $this->hasMany(SupplierAddress::class, 'supplier_id', 'id');

}
    public function transaksisupplier() {
        return $this->hasMany(TransaksiSupplier::class,'company_id', 'id');
}
    public function company() {
        return $this->hasMany(Company::class,'supplier_id', 'id');
}
}
