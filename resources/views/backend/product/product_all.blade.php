@extends('admin.admin_master')
@section('admin')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Products</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('product.add') }}" class="btn btn-dark btn-rounded waves-effect waves-light"
                                style="float:right;"><i class="fas fa-plus-circle"> Add Product</a></i> <br>

                            <h4 class="card-title">Products Data </h4>


                            <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Category</th>
                                        <th>Supplier Name</th>
                                        <th>Product Name</th>
                                        <th>Unit</th>
                                        <th>Product Image</th>
                                        <th>Action</th>

                                </thead>

                                <tbody>

                                    @foreach ($products as $key => $item)
                                        <tr class="text-center">
                                            <td> {{ $key + 1 }} </td>
                                            <td> {{ $item['category']['category_name'] }} </td>
                                            <td> {{ $item['supplier']['supplier_name'] }} </td>
                                            <td> {{ $item->product_name }} </td>
                                            <td> {{ $item['unit']['unit_name'] }} </td>
                                            <td>
                                                <img style="width:60px;height:50px;" src="{{ asset($item->product_image) }}" alt="">
                                            </td>
                                            <td>
                                                <a href="{{ route('product.edit', $item->id) }}" class="btn btn-info sm"
                                                    title="Edit Data"> <i class="fas fa-edit"></i> </a>

                                                <a href="{{ route('product.delete', $item->id) }}" class="btn btn-danger sm" title="Delete Data"
                                                    id="delete"> <i class="fas fa-trash-alt"></i> </a>

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
