<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierAddress extends Model
{
    use HasFactory;

    protected $table = 'supplier_address';
    protected $fillable = ['supplier_id', 'address', 'city', 'state', 'zipcode', 'country'];

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
        public function supplier()
            {
                return $this->belongsTo(Supplier::class);
            }
}
