<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // $now = Carbon::now();

        // $in_invoices = Invoice::whereYear('date', $now->year)->where('type', 0)->get();
        // $out_invoices = Invoice::whereYear('date', $now->year)->where('type', 1)->get();

        // $total_in_invoices = 0;
        // $total_out_invoices = 0;
        // $vat_in = 0;
        // $vat_out = 0;

        // foreach ($in_invoices as $invoice) {
        //     $total_in_invoices += $invoice->total;
        //     $vat_in += ($invoice->total * $invoice->tax_rate) / 100;
        // }

        // foreach ($out_invoices as $invoice) {
        //     $total_out_invoices += $invoice->total;
        //     $vat_out += ($invoice->total * $invoice->tax_rate) / 100;
        // }

        // // Giá trị chênh lệch
        // $deviant = $total_out_invoices - $total_in_invoices;

        return view('star-admin.dashboard');
    }
}
