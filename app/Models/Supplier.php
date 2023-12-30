<?php

namespace App\Models;

use App\Traits\Livewire\HasCategory;
use App\Traits\Livewire\HasChannel;

class Supplier extends BaseModel
{
    use HasChannel, HasCategory;

    protected $fillable = [
        'is_active',
        'code',
        'file_id',
        'name',
        'presentation_name',
        'company',
        'tax_no',
        'address',
        'email',
        'phone',
        'note',
    ];

    public function file(){
        return $this->hasOne(File::class, 'id', 'file_id');
    }
}
