<?php

namespace App\Models;

use App\Traits\Livewire\HasApproved;
use App\Traits\Livewire\HasChannel;
use App\Traits\Livewire\HasCreator;
use App\Traits\Livewire\HasProject;
use App\Traits\Livewire\HasSupplier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierOrder extends Model
{
    use HasFactory, HasChannel, HasSupplier, HasProject, HasCreator, HasApproved;

    protected $fillable = [
        'name',
        'code',
        'supplier_id',
        'project_id',
        'items',
        'tax',
        'note',
    ];
}
