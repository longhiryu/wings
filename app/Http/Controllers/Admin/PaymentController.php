<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends BaseController
{
    public function __construct()
    {
        $this->model = new Payment();

        parent::__construct();
    }

    public function store(Request $request)
    {
        $this->extraFields($request);
        $this->check_total_value($request);

        $data = $request->all();

        return $this->insert_data($data);
    }

    public function update(Request $request, Payment $payment)
    {
        $this->extraFields($request);
        $data = $request->all();

        return $this->insert_data($data, $payment);
    }

    public function extraFields($request)
    {
        $order = Order::find($request->order_id);

        // Nếu đơn hàng bán ra thì loại phiếu là Phiếu thu và ngược lại
        ($order->quotation->type == 1) ? $request->merge(['type' => 0]) : $request->merge(['type' => 1]);

        $request->merge(['customer_id' => $order->customer_id]);
        $request->merge(['created_by' => Auth::user()->id]);
    }

    public function check_total_value($request)
    {
        $order = Order::find($request->order_id);
        $order_total = $order->quotation->total; // Giá trị đơn hàng có thuế
        $total = $request->total; // Giá trị thanh toán đợt này
        $payment_total = $order->payment_total_value(); // Tổng giá trị các phiếu đã thanh toán

        if (($total + $payment_total) > $order_total) {
            return redirect()->back()->withErrors([
                'total_value_eror' => 'Tổng giá trị thanh toán vượt quá Tổng giá trị đơn hàng!',
                'order_total' => 'Giá trị đơn hàng có thuế: ' . myCurrency($order_total),
                'payment_total' => 'Tổng giá trị đã thanh toán: ' . myCurrency($payment_total),
                'total' => 'Giá trị thanh toán đợt này: ' . myCurrency($total),
            ])->withInput();
        }
    }
}
