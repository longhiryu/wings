<?php

namespace App\Models;

use App\Traits\Livewire\HasChannel;
use Illuminate\Database\Eloquent\Model;

class InventoryProduct extends Model
{
    use HasChannel;
    
    protected $fillable = [
        'product_id',
        'supplier_id',
        'project_id',
        'customer_id',
        'type',
        'inventory_id',
        'product_name',
        'import_price',
        'selling_price',
        'product_quantity',
        'product_unit',
    ];

    protected $with = ['product', 'supplier', 'inventory'];

    public function getProductTotalValue($item_id){
        $item = $this->find($item_id);
        if ($item) {
            $total = $item->product_quantity * $item->import_price;

            return $total;
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
