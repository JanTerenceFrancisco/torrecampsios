<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\Unit;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function InvoiceAll()
    {
        $allData = Invoice::orderBy('date', 'DESC')->orderBy('id', 'DESC')->get();
        return view('backend.invoice.invoice_all', compact('allData'));
    }

    public function InvoiceAdd()
    {
        $category = Category::all();
        $invoice_data = Invoice::orderBy('id', 'DESC')->first();

        if ($invoice_data == null) {
            $firstReg = 0;
            $invoice_no = $firstReg + 1;
        } else {
            $invoice_data = Invoice::orderBy('id', 'DESC')->first()->invoice_no;
            $invoice_no = $invoice_data + 1;
        }
        $date = date('Y-m-d');

        return view('backend.invoice.invoice_add', compact('category', 'invoice_no', 'date'));
    }
}
