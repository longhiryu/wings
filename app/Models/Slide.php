<?php

namespace App\Models;

use App\Traits\Livewire\HasActiveScope;
use App\Traits\Livewire\HasChannel;
use App\Traits\Livewire\HasImages;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasImages, HasChannel, HasActiveScope;
}