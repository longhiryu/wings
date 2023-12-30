<?php

namespace App\View\Composers;

use App\Models\Tag;
use Illuminate\View\View;

class TagComposer
{
    protected $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    public function compose(View $view)
    {
        $view->with('tags', $this->tag::all());
    }
}
