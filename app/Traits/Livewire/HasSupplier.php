<?php

namespace App\Traits\Livewire;

use App\Models\Supplier;

trait HasSupplier
{
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
