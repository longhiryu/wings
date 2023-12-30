<?php
 
namespace App\View\Composers;

use App\Models\Category;
use Illuminate\View\View;
 
class CategoryMenuComposer
{
    protected $category;
 
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
 
    public function compose(View $view)
    {
        $view->with('categoryMenu', $this->category->getCategoryForMenu());
    }
}