<?php
 
namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;
 
class CategoryComposer
{
    protected $category;
 
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
 
    public function compose(View $view)
    {
        $view->with('categories', $this->category::where('is_active', 1)->get());
    }
}