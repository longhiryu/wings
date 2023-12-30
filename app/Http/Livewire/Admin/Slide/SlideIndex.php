<?php

namespace App\Http\Livewire\Admin\Slide;

use App\Models\Slide;
use App\Http\Livewire\Admin\BaseComponent;

class SlideIndex extends BaseComponent
{
    public function mount()
    {
        $this->view = 'livewire.admin.slide.index';
        $this->limit = 10;
        $this->model = new Slide(); 
    }
}
