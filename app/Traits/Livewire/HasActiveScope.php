<?php

namespace App\Traits\Livewire;

trait HasActiveScope
{
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
