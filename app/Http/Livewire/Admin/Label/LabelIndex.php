<?php

namespace App\Http\Livewire\Admin\Label;

use App\Http\Livewire\Admin\BaseComponent;
use App\Models\Article;
use App\Models\Label;
use App\Models\Product;

class LabelIndex extends BaseComponent
{

    public function mount()
    {
        $this->limit = 10;
        $this->model = new Label();
        $this->view = 'livewire.admin.label.label-index';
    }

}
