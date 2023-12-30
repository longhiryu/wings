<?php

namespace App\Traits;

use App\Models\Quotation;
use Illuminate\Support\Arr;

trait HasQuotation
{
    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}
