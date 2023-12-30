<?php

namespace App\Traits\Livewire;

use App\Models\User;

trait HasCreator
{
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
