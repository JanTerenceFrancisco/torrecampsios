@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Pending Purchase Orders</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('purchase.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Purchase Order</i></a> <br>

                            <h4 class="card-title">Pending Purchase Orders Data</h4>


                            <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Purchase No.</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Product</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                </thead>

                                <tbody>

                                    @foreach ($allData as $key => $item)
                                        <tr class="text-center">
                                            <td> {{ $item->purchase_no }} </td>
                                            <td> {{ date('m/d/Y', strtotime($item->date)) }} </td>
                                            <td> {{ $item['supplier']['supplier_name'] }} </td>
                                            <td> {{ $item['category']['category_name'] }} </td>
                                            <td> {{ $item->buying_qty }} </td>
                                            <td> {{ $item['product']['product_name'] }} </td>
                                            <td>
                                                @if ($item->status == '0')
                                                    <span class="btn btn-warning">Pending</span>
                                                @elseif($item->status == '1')
                                                    <span class="btn btn-success">Approved</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->status == '0')
                                                    <a href="{{ route('purchase.approve', $item->id) }}" class="btn btn-info sm" title="Approve" id="ApproveBtn"> <i
                                                            class="fas fa-check-circle"></i> </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>
@endsection
