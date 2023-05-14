<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
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
        $customer = Customer::all();
        $invoice_data = Invoice::orderBy('id', 'DESC')->first();

        if ($invoice_data == null) {
            $firstReg = 0;
            $invoice_no = $firstReg + 1;
        } else {
            $invoice_data = Invoice::orderBy('id', 'DESC')->first()->invoice_no;
            $invoice_no = $invoice_data + 1;
        }
        $date = date('Y-m-d');

        return view('backend.invoice.invoice_add', compact('category','customer', 'invoice_no', 'date'));
    }

    public function InvoiceStore(Request $request)
    {
        if ($request->category_id == null) {
            $notification = array(
                'message' => 'Please Select an Item',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        } else {
            if ($request->paid_amount > $request->estimated_amount) {
                $notification = array(
                    'message' => 'Paid Amount is over the Total Amount',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);
            } else {
                
            }
        }
    }
}
