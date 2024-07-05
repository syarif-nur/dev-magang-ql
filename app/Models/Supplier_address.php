<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier_address extends Model
{
    use HasFactory;
    protected $table = 'supplier_address';
    protected $fillable = ['id', 'supplier_id', 'address', 'city', 'state', 'zipcode', 'country'];

    public static function status($i)
    {
        switch ($i) {
            case 1:
                return 'Active';
                break;
                case 2:
                    return 'non Active';
                    break;
                    default:
                    return 'default';
                    break;
        }
    }
}
