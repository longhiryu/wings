<?php

namespace App\View\Composers;

use App\Models\Order;
use Illuminate\View\View;

class OrderComposer
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function compose(View $view)
    {
        $view->with('orders', $this->order::all());
    }
}
