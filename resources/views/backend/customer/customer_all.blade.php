@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Customers</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('customer.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Customer</a></i> <br>

                            <h4 class="card-title">Customer Data</h4>


                            <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Customer Name</th>
                                        <th>Customer Image</th>
                                        <th>Mobile No.</th>
                                        <th>Email</th>
                                        <th>Action</th>

                                </thead>

                                <tbody>

                                    @foreach ($customers as $key => $item)
                                        <tr class="text-center">
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item->customer_name }} </td>
                                            <td>
                                                <img style="width:60px;height:50px;" src="{{ asset($item->customer_image) }}" alt="">
                                            </td>
                                            <td> {{ $item->customer_phone }} </td>
                                            <td> {{ $item->customer_email }} </td>
                                            <td>
                                                <a href="{{ route('customer.edit', $item->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                                <a href="{{ route('customer.delete', $item->id) }}"
                                                    class="btn btn-danger sm" title="Delete Data" id="delete"> <i
                                                        class="fas fa-trash-alt"></i> </a>

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
