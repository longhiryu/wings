<?php

namespace App\Traits\Livewire;

use App\Models\File;

trait HasImages
{
    public function images()
    {
        return $this->morphToMany(File::class, 'filedable');
    }
}
