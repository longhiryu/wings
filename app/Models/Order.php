<?php

namespace App\Models;

use App\Traits\Livewire\HasChannel;

class Order extends BaseModel
{
    use HasChannel;

    protected $fillable = [
        'name',
        'code',
        'customer_id',
        'address_id',
        'source',
        'note',
        'exported',
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id');
    }

    public function address(){
        return $this->belongsTo(Address::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function exportProducts(){
        return $this->hasMany(OrderExport::class);
    }
}