<?php

namespace App\Models;

use App\Traits\Livewire\HasChannel;

class Inventory extends BaseModel
{
    use HasChannel;
    
    protected $fillable = [
        'is_active',
        'code',
        'name',
        'address',
        'email',
        'phone',
        'manager_id',
        'note',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manger_id');
    }
}
