<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relation\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $table = 'company';
    protected $fillable = ['supplier_id', 'company_name', 'address', 'city', 'state', 'postal_code', 'contry', 'phone_number', 'website'];

    public static function status($i) {
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
}
