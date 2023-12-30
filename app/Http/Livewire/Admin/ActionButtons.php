<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class ActionButtons extends Component
{
    public $view_id;
    public $route_edit;
    public $route_delete;
    public function render()
    {
        return view('livewire.admin.action-buttons');
    }
}
