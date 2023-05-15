<?php

namespace App\Http\Controllers\Pos;

use App\Models\Unit;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\InvoiceDetail;
use App\Models\PaymentDetail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function InvoiceAll()
    {
        $allData = Invoice::orderBy('date', 'DESC')->orderBy('id', 'DESC')->where('status', '1')->get();
        return view('backend.invoice.invoice_all', compact('allData'));
    }

    public function InvoiceAdd()
    {
        $category = Category::all();
        $customer = Customer::all();
        $invoice_data = Invoice::orderBy('id', 'DESC')->first();

        if ($invoice_data == null) {
            $firstReg = '0';
            $invoice_no = $firstReg + 1;
        } else {
            $invoice_data = Invoice::orderBy('id', 'DESC')->first()->invoice_no;
            $invoice_no = $invoice_data + 1;
        }
        $date = date('Y-m-d');

        return view('backend.invoice.invoice_add', compact('category', 'customer', 'invoice_no', 'date'));
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

                $invoice = new Invoice();
                $invoice->invoice_no = $request->invoice_no;
                $invoice->date = date('Y-m-d', strtotime($request->date));
                $invoice->description = $request->description;
                $invoice->status = '0';
                $invoice->created_by = Auth::user()->id;
                $invoice->created_at = Carbon::now();


                DB::transaction(function () use ($request, $invoice) {

                    if ($invoice->save()) {
                        $count_category = count($request->category_id);
                        for ($i = 0; $i < $count_category; $i++) {
                            $invoice_details = new InvoiceDetail();
                            $invoice_details->date = date('Y-m-d', strtotime($request->date));
                            $invoice_details->invoice_id = $invoice->id;
                            $invoice_details->category_id = $request->category_id[$i];
                            $invoice_details->product_id = $request->product_id[$i];
                            $invoice_details->selling_qty = $request->selling_qty[$i];
                            $invoice_details->unit_price = $request->unit_price[$i];
                            $invoice_details->selling_price = $request->selling_price[$i];
                            $invoice->status = '0';
                            $invoice_details->created_at = Carbon::now();

                            $invoice_details->save();
                        }

                        if ($request->customer_id == '0') {
                            $customer = new Customer();
                            $customer->customer_name = $request->customer_name;
                            $customer->customer_phone = $request->customer_phone;
                            $customer->customer_email = $request->customer_email;
                            $customer->customer_address1 = $request->customer_address1;
                            $customer->customer_address2 = $request->customer_address2;
                            $customer->customer_city = $request->customer_city;
                            $customer->customer_province = $request->customer_province;
                            $customer->customer_zipcode = $request->customer_zipcode;

                            $customer->save();
                            $customer_id = $customer->id;
                        } else {
                            $customer_id = $request->customer_id;
                        }

                        $payment = new Payment();
                        $payment_details = new PaymentDetail();

                        $payment->invoice_id = $invoice->id;
                        $payment->customer_id = $customer_id;
                        $payment->paid_status = $request->paid_status;
                        $payment->discount_amount = $request->discount_amount;
                        $payment->total_amount = $request->estimated_amount;

                        if ($request->paid_status == 'full_paid') {
                            $payment->paid_amount = $request->estimated_amount;
                            $payment->due_amount = '0';
                            $payment_details->current_paid_amount = $request->estimated_amount;
                        } elseif ($request->paid_status == 'full_due') {
                            $payment->paid_amount = '0';
                            $payment->due_amount = $request->estimated_amount;
                            $payment_details->current_paid_amount = '0';
                        } elseif ($request->paid_status == 'partial_paid') {
                            $payment->paid_amount = $request->paid_amount;
                            $payment->due_amount = $request->estimated_amount - $request->paid_amount;
                            $payment_details->current_paid_amount = $request->paid_amount;
                        }
                        $payment->save();

                        $payment_details->invoice_id = $invoice->id;
                        $payment_details->date = date('Y-m-d', strtotime($request->date));
                        $payment_details->save();
                    }
                });
            }
        }

        $notification = array(
            'message' => 'Invoice Created',
            'alert-type' => 'success'
        );
        return redirect()->route('invoice.pending.list')->with($notification);

    }

    public function PendingList()
    {
        $allData = Invoice::orderBy('date', 'DESC')->orderBy('id', 'DESC')->where('status', '0')->get();
        return view('backend.invoice.invoice_pending_list', compact('allData'));
    }

    public function InvoiceDelete($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        InvoiceDetail::where('invoice_id', $invoice->id)->delete();
        Payment::where('invoice_id', $invoice->id)->delete();
        PaymentDetail::where('invoice_id', $invoice->id)->delete();

        $notification = array(
            'message' => 'Invoice Deleted',
            'alert-type' => 'info'
        );
        return redirect()->back()->with($notification);
    }

    public function InvoiceApprove($id)
    {
        $invoice = Invoice::with('invoice_details')->findOrFail($id);
        return view('backend.invoice.invoice_approve', compact('invoice'));
    }

    public function ApprovalStore(Request $request, $id)
    {
        foreach($request->selling_qty as $key => $value){
            $invoice_details = InvoiceDetail::where('id', $key)->first();
            $product = Product::where('id', $invoice_details->product_id)->first();
            if($product->quantity < $request->selling_qty[$key]){

                $notification = array(
                    'message' => 'Sorry, you approved a maximum value',
                    'alert-type' => 'error'
                );
                return redirect()->back()->with($notification);

            }
        }
    }
}
