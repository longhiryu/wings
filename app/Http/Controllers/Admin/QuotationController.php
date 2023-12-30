<?php

namespace App\Http\Controllers\Admin;

use PDF;
use App\Models\Quotation;
use Illuminate\Http\Request;
use App\Models\ProductQuotation;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class QuotationController extends BaseController
{
    protected $quotation_key;

    public function __construct()
    {
        $this->model = new Quotation();
        $this->quotation_key = Config::get('quotation.session_key');
        parent::__construct();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $list = session($this->quotation_key);

        $sub_total = 0;
        foreach ($list as $product) {
            $sub_total += $product['product_price'] * $product['product_quantity'];
        }

        $request->merge([
            'sub_total' => $sub_total,
            'total' => $sub_total + ($sub_total * request('tax_rate') / 100),
        ]);

        $data = $request->all();

        return $this->insert_data($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quotation $quotation)
    {
        $list = session($this->quotation_key);

        $sub_total = 0;
        if ($list) {
            foreach ($list as $product) {
                $sub_total += $product['product_price'] * $product['product_quantity'];
            }
        }

        $request->merge([
            'sub_total' => $sub_total,
            'total' => $sub_total + ($sub_total * request('tax_rate') / 100),
        ]);

        // delete old data
        ProductQuotation::where('quotation_id', $quotation->id)->delete();

        $data = $request->all();

        return $this->insert_data($data, $quotation);
    }

    public function add(Request $request)
    {
        $data = $request->all();

        //check if seassion prolist exist
        if (session()->has($this->quotation_key)) {
            session()->push($this->quotation_key, $data);
        } else {
            $list = [];
            $list[] = $data;
            session()->put($this->quotation_key, $list);
        }

        return view('backend.layouts.product.product_list');
    }

    public function remove()
    {
        $prolist = session($this->quotation_key);
        $id = request('product_id');
        $price = request('product_price');
        $quantity = request('product_quantity');
        if ($prolist) {
            foreach ($prolist as $key => $pro) {
                if ($pro['product_id'] == $id && $pro['product_price'] == $price && $pro['product_quantity'] == $quantity) {
                    unset($prolist[$key]);
                }
            }
        }

        session()->put($this->quotation_key, $prolist);

        return view('backend.layouts.product.product_list');
    }

    public function clear()
    {
        session()->forget($this->quotation_key);
    }

    public function exportPDF(Quotation $quotation)
    {
        // share data to view
        view()->share('quotation', $quotation);
        $data = $quotation->toArray();
        $owner = Config::get('owner');

        $pdf = PDF::loadView('backend.layouts.quotation.export_pdf', compact('quotation', 'owner'));

        // download PDF file with download method
        return $pdf->download($quotation->name . 'quotation.pdf');
    }
}
