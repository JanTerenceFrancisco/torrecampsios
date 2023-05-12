@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <a href="{{ route('customer.all') }}" class="btn btn-danger btn-rounded waves-effect waves-light"
                                style="float:right;">Back</a> <br>

                            <h4 class="card-title">Edit Customer</h4> <br>

                            

                            <form method="POST" action="{{ route('customer.update') }}" id="myForm" enctype="multipart/form-data">
                                @csrf

                                <input type="hidden" name="id" value="{{ $customer->id }}">
                                
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Customer Name</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" value="{{ $customer->customer_name }}" name="customer_name" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Customer Phone No.</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" value="{{ $customer->customer_phone }}" name="customer_phone" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Customer Email</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" value="{{ $customer->customer_email }}" name="customer_email" type="email">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Address Line 1</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" value="{{ $customer->customer_address1 }}" name="customer_address1" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Address Line 2</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" value="{{ $customer->customer_address2 }}" name="customer_address2" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">City</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" value="{{ $customer->customer_city }}" name="customer_city" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Province</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" value="{{ $customer->customer_province }}" name="customer_province" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Postal Code</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" value="{{ $customer->customer_zipcode }}" name="customer_zipcode" type="text">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">Customer Image</label>
                                    <div class="form-group col-sm-10">
                                        <input class="form-control" name="customer_image" type="file" id="image">
                                    </div>
                                </div>
                                <!-- end row -->

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <img id="showImage" class="rounded avatar-lg"
                                            src="{{ asset($customer->customer_image) }}"
                                            alt="Card image cap">
                                    </div>
                                </div>
                                <!-- end row -->

                                <input type="submit" class="btn btn-info waves-effect waves-light" value="Update">

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
                    customer_name: {
                        required : true,
                    }, 
                    customer_phone: {
                        required : true,
                    }, 
                    customer_email: {
                        required : true,
                    }, 
                    customer_address1: {
                        required : true,
                    }, 
                    customer_city: {
                        required : true,
                    }, 
                    customer_province: {
                        required : true,
                    }, 
                    customer_zipcode: {
                        required : true,
                    }, 
                },
                messages :{
                    customer_name: {
                        required : 'Please Enter Customer Name',
                    },
                    customer_phone: {
                        required : 'Please Enter Customer Phone Number',
                    },
                    customer_email: {
                        required : 'Please Enter Customer Email',
                    },
                    customer_address1: {
                        required : 'Please Enter Customer Address Line 1',
                    },
                    customer_city: {
                        required : 'Please Enter Customer City',
                    },
                    customer_province: {
                        required : 'Please Enter Customer Province',
                    },
                    customer_zipcode: {
                        required : 'Please Enter Customer Postal Code',
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

<script type="text/javascript">
    $(document).ready(function() {
        $('#image').change(function(e) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection
