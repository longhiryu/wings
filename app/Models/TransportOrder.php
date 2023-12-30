<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransportOrder extends Model
{
    protected $fillable = [
        'name',
        'export_id',
        'supplier_id',
        'project_id',
        'inventory_id',
        'transport_fee',
        'note'
    ];
}
