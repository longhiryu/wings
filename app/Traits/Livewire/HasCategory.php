<?php

namespace App\Traits\Livewire;

use App\Models\Category;
use Illuminate\Support\Arr;

trait HasCategory
{
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
