<?php

namespace App\Http\Livewire\Admin\Slide;

use App\Http\Livewire\Admin\BaseComponent;
use App\Models\Slide;

class SlideEdit extends BaseComponent
{
    public $keyword;
    public $error;
    protected $rules = [
        'model.id' => 'nullable',
        'model.is_active' => 'nullable',
        'model.name' => 'nullable',
        'model.note' => 'nullable',
        'model.content' => 'nullable',
        'model.slug' => 'nullable',
    ];

    public function mount(Slide $slide)
    {
        $this->view = 'livewire.admin.slide._form';
        $this->viewEdit = 'slide.edit';
        $this->viewIndex = 'slide';
        $this->model = $slide;
        $this->imagesModal = true;
        $this->moreImages = $this->model->images ? $this->model->images : null;
    }
}
