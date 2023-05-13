<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function InvoiceAll()
    {
        $allData = Invoice::orderBy('date', 'DESC')->orderBy('id', 'DESC')->get();
        return view('backend.invoice.invoice_all', compact('allData'));
    }
}
