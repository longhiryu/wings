<?php

namespace App\View\Composers;

use App\Models\Customer;
use Illuminate\View\View;

class CustomerComposer
{
    protected $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function compose(View $view)
    {
        $view->with('customers', $this->customer::select('id','company_name')->get());
    }
}
