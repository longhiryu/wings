<?php

namespace App\View\Composers;

use App\Models\Company;
use Illuminate\View\View;

class CompanyComposer
{
    protected $company;

    public function __construct(Company $company)
    {
        $this->company = $company;
    }

    public function compose(View $view)
    {
        $view->with('companies', $this->company::all());
    }
}
