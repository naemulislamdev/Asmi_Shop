@extends('layouts.admin')
@section('styles')
    {{-- <link href="{{ asset('assets/admin/css/jquery-ui.css') }}" rel="stylesheet" type="text/css"> --}}
    <style>
.print-table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
}

.print-table th {
    background: #f1f1f1;
    padding: 8px;
    border: 1px solid #ccc;
    text-align: left;
    font-weight: bold;
}

.print-table td {
    padding: 8px;
    border: 1px solid #ddd;
}
</style>
@endsection
@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Create An Order') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Orders') }} </a>
                        </li>
                        <li>
                            <a href="{{ route('admin-order-create') }}">{{ __('Create An Order') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="add-product-content1 add-product-content2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <form action="{{ route('admin.order.create.view') }}" method="POST">
                            @csrf
                            <div class="gocover"
                                style="background: url({{ asset('assets/images/' . $gs->admin_loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>

                            @include('alerts.admin.form-both')


                            <div class="product-area">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="py-4 px-4 my-2 mx-4 border">
                                            <div class="text-center">
                                                <h3>User Details</h3>
                                            </div>
                                            <hr>
                                            <div class="row mt-2">
                                                <div class="col-md-6 col-sm-6">
                                                    <label for="name">Name *</label>
                                                    <input type="text" class="form-control" required name="customer_name"
                                                        id="name" placeholder="Name">
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <label for="phone">Phone *</label>
                                                    <input type="text" class="form-control" required
                                                        name="customer_phone" id="phone" placeholder="Phone">
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <label for="customer_address">Address *</label>
                                                    <input type="text" class="form-control" required
                                                        name="customer_address" id="customer_address" placeholder="Address">
                                                </div>
                                            </div>
                                            {{-- <div id="order_create_user_address">
                                                @include('admin.order.create.address_form')
                                            </div> --}}

                                        </div>
                                        <div>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Measured</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($custome_products as $custome_product)
                                                        <tr>
                                                            <td>{{ $custome_product->name }}</td>
                                                            <td>{{ $custome_product->measurement }}</td>
                                                            <td>{{ $custome_product->price }}</td>
                                                            <td>{{ $custome_product->quantity }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div id="custome-order" class="py-4 px-4 my-2 mx-4 border">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Product Name</th>
                                                        <th>Measured</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Subtotal</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" id="product_name"
                                                                value="" placeholder="Product Name">
                                                        </td>
                                                        <td>
                                                            <select class="form-control mt-2" id="measured_type">
                                                                <option value="kg">Kg</option>
                                                                <option value="pcs">Pcs</option>
                                                                <option value="gm">Gm</option>
                                                                <option value="ltr">Ltr</option>
                                                            </select>
                                                            <input type="text" class="form-control" id="measured"
                                                                value="" placeholder="Measured">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control product_price"
                                                                id="product_price" value=""
                                                                placeholder="Product Price">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control product_quantity"
                                                                id="product_quantity" value=""
                                                                placeholder="Product Quantity">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control subtotal"
                                                                id="subtotal" value="" placeholder="Subtotal">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a href="javascript:;" class="btn btn-primary btn-sm addOrder">Add</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="text-center float-end">
                        <button class="btn btn-primary" type="button"
                            id="printInvoiceBtn">{{ __('Print Order Invoice') }}</button>
                    </div>
                </div>
            </div>
            <div id="printArea" style="display:none;">
                <h2 style="text-align:center;">Order Invoice</h2>
                <hr>

                <h4>User Details</h4>
                <p>Name: <span id="p_name"></span></p>
                <p>Phone: <span id="p_phone"></span></p>
                <p>Address: <span id="p_address"></span></p>

                <h4>Order Items</h4>
                <table border="1" width="100%" cellpadding="6" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Measured</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="printTableBody"></tbody>
                </table>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // Add new row
            $(document).on('click', '.addOrder', function() {

                let newRow = `
        <tr>
            <td>
                <input type="text" class="form-control product_name" placeholder="Product Name">
            </td>
            <td>
                <select class="form-control mt-2 measured_type">
                    <option value="kg">Kg</option>
                    <option value="pcs">Pcs</option>
                    <option value="gm">Gm</option>
                    <option value="ltr">Ltr</option>
                </select>
                <input type="text" class="form-control measured" placeholder="Measured">
            </td>
            <td>
                <input type="text" class="form-control product_price" placeholder="Product Price">
            </td>
            <td>
                <input type="text" class="form-control product_quantity" placeholder="Product Quantity">
            </td>
            <td>
                <input type="text" class="form-control subtotal" placeholder="Subtotal">
            </td>
            <td>
                <a href="javascript:;" class="btn btn-danger btn-sm removeOrder">Remove</a>
            </td>
        </tr>
        `;
                $("#custome-order tbody").append(newRow);
            });

            // Remove row
            $(document).on('click', '.removeOrder', function() {
                $(this).closest('tr').remove();
            });

            // Auto calculate subtotal (price * qty)
            $(document).on('keyup change', '.product_price, .product_quantity', function() {
                let row = $(this).closest('tr');

                let price = parseFloat(row.find('.product_price').val()) || 0;
                let qty = parseFloat(row.find('.product_quantity').val()) || 0;

                let subtotal = price * qty;

                row.find('.subtotal').val(subtotal.toFixed(2));
            });

        });
    </script>
    <script>
        $(document).on("click", "#printInvoiceBtn", function() {

            // Get user details
            let name = $("input[name='customer_name']").val();
            let phone = $("input[name='customer_phone']").val();
            let address = $("textarea[name='customer_address']").val();

            $("#p_name").text(name);
            $("#p_phone").text(phone);
            $("#p_address").text(address);

            // Clear old rows
            $("#printTableBody").html("");

            // Loop through each order row
            $("#custome-order tbody tr").each(function() {
                let product = $(this).find("#product_name").val();
                let measuredType = $(this).find("#measured_type").val();
                let measured = $(this).find("#measured").val();
                let price = $(this).find(".product_price").val();
                let qty = $(this).find(".product_quantity").val();
                let subtotal = $(this).find(".subtotal").val();

                if (product !== "") {
                    $("#printTableBody").append(`
                <tr>
                    <td>${product}</td>
                    <td>${measured} ${measuredType}</td>
                    <td>${price}</td>
                    <td>${qty}</td>
                    <td>${subtotal}</td>
                </tr>
            `);
                }
            });

            // Print Function
            let printContents = document.getElementById("printArea").innerHTML;
            let printWindow = window.open("", "", "width=900,height=600");
            printWindow.document.write(`
        <html>
            <head>
                <title>Order Invoice</title>
            </head>
            <body>${printContents}</body>
        </html>
    `);
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        });
    </script>
@endpush
