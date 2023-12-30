<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectProduct extends Model
{
    protected $fillable = [
        'project_id',
        'product_id',
        'product_name',
        'product_price',
        'product_quantity',
        'product_unit',
    ];
}
