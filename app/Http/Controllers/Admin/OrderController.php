<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Quotation;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function __construct()
    {
        $this->model = new Order();
        parent::__construct();
    }

    public function store(Request $request)
    {
        $quotation = Quotation::select('customer_id')->where('id',request('quotation_id'))->first();
        $request->merge(['customer_id' => $quotation->customer_id]);
        
        return $this->insert_data($request);
    }

    public function update(Request $request, Order $order)
    {
        return $this->insert_data($request, $order);
    }
}
