<?php

namespace App\View\Composers;

use App\Models\Quotation;
use Illuminate\View\View;

class QuotationComposer
{
    protected $quotation;

    public function __construct(Quotation $quotation)
    {
        $this->quotation = $quotation;
    }

    public function compose(View $view)
    {
        $view->with('quotations', $this->quotation::all());
    }
}
