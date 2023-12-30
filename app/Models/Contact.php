<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'code',
        'avatar',
        'phone',
        'address',
        'email',
        'position',
        'function',
        'category_id',
        'supplier_id',
        'customer_id',
        'project_id',
        'note'
    ];
}
