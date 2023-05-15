@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->

            @php
                $payment = App\Models\Payment::where('invoice_id', $invoice->id)->first();
            @endphp

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Approve Invoice</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4>Invoice No: #{{ $invoice->invoice_no }} - {{ date('m/d/Y', strtotime($invoice->date)) }}
                            </h4>

                            <a href="{{ route('invoice.pending.list') }}"
                                class="btn btn-dark btn-rounded waves-effect waves-light" style="float:right;"><i
                                    class="fa fa-list"> Pending Invoices</a></i> <br>

                            <br>
                            <table class="table table-dark" width="100%">
                                <tbody>
                                    <tr>
                                        <td>
                                            <p>Customer Info</p>
                                        </td>
                                        <td>
                                            <p>
                                                Customer Name: <strong>{{ $payment['customer']['customer_name'] }}</strong>
                                            </p>
                                        </td>
                                        <td>
                                            <p>Customer Phone No.:
                                                <strong>{{ $payment['customer']['customer_phone'] }}</strong>
                                            </p>
                                        </td>
                                        <td>
                                            <p>
                                                Customer Address: <strong>{{ $payment['customer']['customer_address1'] }},
                                                    {{ $payment['customer']['customer_address2'] }},
                                                    {{ $payment['customer']['customer_city'] }},
                                                    {{ $payment['customer']['customer_province'] }},
                                                    {{ $payment['customer']['customer_zipcode'] }}</strong>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>

                                        </td>
                                        <td colspan="3">
                                            <p>Description:
                                                <strong>{{ $invoice->description }}</strong>
                                            </p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <form method="POST" action="{{ route('approval.store', $invoice->id) }}">
                                @csrf

                                <table class="table table-dark" border="1" width="100%">

                                    <thead>
                                        <tr>
                                            <th class="text-center">Sl</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center" style="background-color: #8b008b">Current Stock</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Unit Price</th>
                                            <th class="text-center">Total Price</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @php
                                            $total_price = '0';
                                        @endphp
                                        @foreach ($invoice['invoice_details'] as $key => $item)
                                            <tr class="text-center">

                                                <input type="hidden" name="category_id[]"
                                                    value="{{ $item->category_id }}">
                                                <input type="hidden" name="product_id[]" value="{{ $item->product_id }}">
                                                <input type="hidden" name="selling_qty[{{ $item->id }}]"
                                                    value="{{ $item->selling_qty }}">

                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item['category']['category_name'] }}</td>
                                                <td>{{ $item['product']['product_name'] }}</td>
                                                <td style="background-color: #8b008b">{{ $item['product']['quantity'] }}
                                                </td>
                                                <td>{{ $item->selling_qty }}</td>
                                                <td>{{ $item->unit_price }}</td>
                                                <td>{{ $item->selling_price }}</td>
                                            </tr>
                                            @php
                                                $total_price += $item->selling_price;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="6">Sub Total</td>
                                            <td>{{ $total_price }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Discount</td>
                                            <td>{{ $payment->discount_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Paid Amount</td>
                                            <td>{{ $payment->paid_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Due Amount</td>
                                            <td>{{ $payment->due_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">Grand Total</td>
                                            <td>{{ $payment->total_amount }}</td>
                                        </tr>
                                    </tbody>

                                </table>

                                <button type="submit" class="btn btn-info">Approve</button>

                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
@endsection
