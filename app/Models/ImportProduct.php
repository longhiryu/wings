<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportProduct extends Model
{
    protected $fillable = [
        'import_id',
        'product_id',
        'product_name',
        'import_price',
        'selling_price',
        'product_quantity',
        'product_unit',
    ];
}
