<?php

namespace App\Models;

use App\Traits\Livewire\HasChannel;
use Illuminate\Database\Eloquent\Model;

class Import extends Model
{
    use HasChannel;

    protected $fillable = [
        'name',
        'items',
        'code',
        'user_id',
        'supplier_id',
        'project_id',
        'customer_id',
        'inventory_id',
        'import_date',
        'is_imported'
    ];
        
    /**
     * Method getImportTotalValue
     *
     * @return double
     */
    public function getImportTotalValue(){
        $items = json_decode($this->items, true);
        if (!$items or empty($items)) {
            return 0;
        }
        return array_reduce($items, function ($carry, $item) {
            return $carry + ($item['import_price'] * $item['product_quantity']);
        }, 0);
    }

    /**
     * Get the user associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the supplier associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the customer associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the inventory associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    
    /**
     * Get the import products associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function import_products()
    {
        return $this->hasMany(ImportProduct::class, 'import_id');
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }
}
