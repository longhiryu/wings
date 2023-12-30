<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\File as ModelsFile;
use Illuminate\Support\Facades\File;

class InvoiceController extends BaseController
{
    protected $invoice_folder_path;

    protected $order_total; // Giá trị đơn hàng có thuế
    protected $total_invoice; // Giá trị hoá đơn đã xuất có thuế
    protected $total; // Giá trị hoá đơn đợt này có thuế

    public function __construct()
    {
        $this->model = new Invoice();
        parent::__construct();

        $this->invoice_folder_path = 'invoices';
        File::ensureDirectoryExists(public_path() . '/invoices');
    }

    public function store(Request $request)
    {
        $this->prepare_value($request);

        if ($request->hasFile('fileToUpload')) {
            $this->invoice_upload_file($request);
        }

        if ($this->check_total($request)) {
            return $this->insert_data($request);
        }else{
            return redirect()->back()->withErrors([
                'total_value_eror' => 'Tổng giá trị hoá đơn vượt quá Tổng giá trị đơn hàng!',
                'order_total' => 'Giá trị đơn hàng có thuế: '.myCurrency($this->order_total),
                '$total_invoice' => 'Giá trị hoá đơn có thuế đã xuất: '.myCurrency($this->total_invoice),
                'total' => 'Giá trị hoá đơn đợt này: '.myCurrency($this->total)
            ])->withInput();
        }

    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->prepare_value($request);

        if ($request->hasFile('fileToUpload')) {
            $this->invoice_upload_file($request);
        }

        $data = $request->all();

        return $this->insert_data($data, $invoice);
    }

    public function invoice_upload_file($request)
    {
        $file = $request->file('fileToUpload');

        $file_data['name'] = $file->getClientOriginalName();
        $file_data['extension'] = $file->getClientOriginalExtension();
        $file_data['mime'] = $file->getMimeType();
        $file_data['path'] = $this->invoice_folder_path . '/' . $file->getClientOriginalName();
        $file_data['size'] = $file->getSize();

        // Create File record
        $file_entity = ModelsFile::create($file_data);

        // define files[] relationship
        $request->merge(['files' => [$file_entity->id]]);

        // upload file
        $file->move(public_path() . '/' .$this->invoice_folder_path, $file->getClientOriginalName());
    }

    public function prepare_value($request)
    {
        $order = Order::where('id', request('order_id'))->first();
        $total = ($request->value * $order->quotation->tax_rate) / 100 + $request->value;
        $request->merge(['customer_id' => $order->customer_id]);
        $request->merge(['type' => $order->quotation->type]);
        $request->merge(['total' => $total]);
        $request->merge(['tax_rate' => $order->quotation->tax_rate]);
    }

    public function check_total($request)
    {
        $order = Order::where('id', $request->order_id)->first();
        // Giá trị đơn hàng có thuế
        $order_total = $this->order_total = $order->quotation->total;
        // Tổng giá trị hóa đơn đã xuất
        $total_invoice = $this->total_invoice = $order->total_invoices_value();
        // Hóa đơn đợt này
        $total = $this->total = ($request->value * $order->quotation->tax_rate) / 100 + $request->value;

        // Giá trị hoá đơn đã xuất + Đợt này lớn hơn Giá trị đơn hàng
        if (($total_invoice + $total) > $order_total) {
            return false;
        }

        return true;
    }
}
