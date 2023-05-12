@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">Edit Supplier</h4> <br>


                            <form method="POST" action="{{ route('supplier.update') }}" id="myForm">
                                @csrf
                                <input type="hidden" name="id" value="{{ $supplier->id }}">

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Name</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" name="supplier_name" value="{{ $supplier->supplier_name }}" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Phone No.</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" name="supplier_phone" value="{{ $supplier->supplier_phone }}" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Email</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" name="supplier_email" value="{{ $supplier->supplier_email }}" type="email">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Supplier Address</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" name="supplier_address" value="{{ $supplier->supplier_address }}" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Update Supplier">

                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    supplier_name: {
                        required : true,
                    }, 
                    supplier_phone: {
                        required : true,
                    }, 
                    supplier_email: {
                        required : true,
                    }, 
                    supplier_address: {
                        required : true,
                    }, 
                },
                messages :{
                    supplier_name: {
                        required : 'Please Enter Supplier Name',
                    },
                    supplier_phone: {
                        required : 'Please Enter Supplier Phone Number',
                    },
                    supplier_email: {
                        required : 'Please Enter Supplier Email',
                    },
                    supplier_address: {
                        required : 'Please Enter Supplier Address',
                    },
                },
                errorElement : 'span', 
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });
        
    </script>

@endsection
