<?php

namespace App\View\Composers;

use App\Models\Product;
use Illuminate\View\View;

class ProductComposer
{
    protected $category;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function compose(View $view)
    {
        $view->with('products', $this->product::where('is_active', 1)->get());
    }
}
