<?php

namespace App\Traits;

use App\Models\Order;

trait HasOrder
{
    public function orders()
    {
        return $this->hasMany(Order::class)->orderBy('created_at','DESC');
    }
}
