<?php

namespace App\Models;

use App\Traits\Livewire\HasChannel;
use App\Traits\Livewire\HasCreator;
use App\Traits\Livewire\HasProject;
use App\Traits\Livewire\HasCustomer;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasChannel, HasCreator, HasCustomer, HasProject;

    protected $fillable = [
        'code',
        'items',
        'creator_id',
        'customer_id',
        'project_id',
        'export_status',
        'export_date',
        'delivery_address',
        'inventory_id',
        'reciever_name',
        'reciever_phone',
        'driver_name',
        'driver_phone',
        'driver_plate',
        'note',
    ];
}
