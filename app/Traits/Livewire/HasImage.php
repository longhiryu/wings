<?php

namespace App\Traits\Livewire;

use App\Models\File;

trait HasImage
{
    public function image()
    {
        return $this->morphToMany(File::class, 'filedable');
    }
}
