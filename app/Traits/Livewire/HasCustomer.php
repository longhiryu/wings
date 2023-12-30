<?php

namespace App\Traits\Livewire;

use App\Models\Customer;

trait HasCustomer
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
