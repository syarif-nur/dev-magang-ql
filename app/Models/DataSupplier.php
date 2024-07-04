<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use illuminate\Database\Eloquent\Relations\HasMany;

class DataSupplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';
    protected $fillable = ['firstname', 'lastname', 'email', 'phone'];

    public static function status ($i){
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
}
