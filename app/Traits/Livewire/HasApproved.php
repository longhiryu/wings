<?php

namespace App\Traits\Livewire;

use App\Models\User;

trait HasApproved
{
    public function approved()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
