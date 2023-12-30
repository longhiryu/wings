<?php

namespace App\Traits\Livewire;

use App\Models\Project;

trait HasProject
{
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
