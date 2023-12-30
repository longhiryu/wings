<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class SidebarItem extends Component
{
    public $model;

    public $keyword;

    public $icon;

    public function render()
    {
        return view('livewire.admin.sidebar-item');
    }
}
