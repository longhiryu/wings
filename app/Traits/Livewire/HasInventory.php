<?php

namespace App\Traits\Livewire;

use App\Models\Inventory;

trait HasInventory
{
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
