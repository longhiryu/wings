<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends BaseController
{
    public function __construct()
    {
        $this->model = new Customer();
        parent::__construct();
    }

    public function store(CreateCustomerRequest $request)
    {
        return $this->insert_data($request);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        return $this->insert_data($request, $customer);
    }

    public function getInfo()
    {
        $mst = request('mst');
        $string = callAPI('https://thongtindoanhnghiep.co/api/company/'.$mst);

        return json_decode($string, true);
    }
}
