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
        $supplier = Supplier::all();
        $unit = Unit::all();
        $category = Category::all();

        return view('backend.invoice.invoice_add', compact('supplier', 'unit', 'category'));
    }
}
