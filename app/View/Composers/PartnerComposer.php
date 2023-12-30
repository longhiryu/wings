<?php

namespace App\View\Composers;

use App\Models\Partner;
use Illuminate\View\View;

class PartnerComposer
{
    protected $partner;

    public function __construct(Partner $partner)
    {
        $this->partner = $partner;
    }

    public function compose(View $view)
    {
        $view->with('partners', $this->partner::all());
    }
}
