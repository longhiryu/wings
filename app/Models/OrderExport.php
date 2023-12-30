<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderExport extends Model
{
    protected $fillable = [
        'inventory_product_id',
        'order_id',
        'export_quantity'
    ];

    public function inventoryProduct(){
        return $this->belongsTo(InventoryProduct::class);
    }
}
