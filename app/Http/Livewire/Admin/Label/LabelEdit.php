<?php

namespace App\Http\Livewire\Admin\Label;


use App\Http\Livewire\Admin\BaseComponent;
use App\Models\Label;

class LabelEdit extends BaseComponent
{
    public $keyword;
    public $error;
    
    protected $rules = [
        'model.id' => 'nullable',
        'model.slug' => 'required',
        'model.locale' => 'nullable',
        'model.name' => 'nullable',
    ];

    public function mount(Label $label)
    {
        $this->view = 'livewire.admin.label._form';
        $this->model = $label;
        $this->viewEdit = 'label.edit';
    }
}
