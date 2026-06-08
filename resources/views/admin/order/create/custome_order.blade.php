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
                    <h4 class="heading">Create An Order</h4>
                </div>
            </div>
        </div>

        <div class="add-product-content1 add-product-content2">
            <form>
                <div class="product-area">
                    <div class="row">
                        <div class="col-lg-12">

                            {{-- USER DETAILS --}}
                            <div class="py-4 px-4 my-2 mx-4 border">
                                <h4 class="text-center">Customer Details</h4>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="customer_name">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="customer_phone">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Order Number</label>
                                        <input type="text" class="form-control" name="order_number">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="customer_address">
                                    </div>
                                    <div class="col-md-12">
                                        <label>Note</label>
                                        <input type="text" class="form-control" name="note">
                                    </div>
                                </div>
                            </div>

                            {{-- ORDER TABLE --}}
                            <div class="py-4 px-4 my-2 mx-4 border">
                                <table class="table table-bordered" id="orderTable">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Measure Label</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" class="form-control product_name"></td>
                                            <td>
                                                <input type="text" class="form-control measure_label"
                                                    placeholder="eg: 1kg, 500g, 1.5kg, 2pcs">
                                            </td>
                                            <td><input type="number" step="0.001" class="form-control quantity"></td>
                                            <td><input type="number" step="0.01" class="form-control unit_price"></td>
                                            <td><input type="number" step="0.01" class="form-control subtotal" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <button type="button" class="btn btn-primary btn-sm addOrder">
                                    <i class="fa fa-plus-circle"></i> Add Product
                                </button>

                                <!-- PRINT BUTTON -->
                                <button type="button" class="btn btn-success btn-sm float-end" id="printInvoice"> <i class="fa fa-print"></i> Print Invoice
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= INVOICE PRINT AREA (HIDDEN) ================= -->
    <div id="invoiceArea" style="display:none;">
        <div style="text-align:center;">
            <img id="inv_logo" src="" style="max-height:80px;">
            <h2>Order Invoice</h2>
            <p>Date: <span id="inv_date"></span></p>
        </div>

        <hr>

        <p><strong>Order Number:</strong> <span id="inv_order_number"></span></p>
        <p><strong>Name:</strong> <span id="inv_name"></span></p>
        <p><strong>Phone:</strong> <span id="inv_phone"></span></p>
        <p><strong>Address:</strong> <span id="inv_address"></span></p>
        <p><strong>Note:</strong> <span id="inv_note"></span></p>

        <table width="100%" border="1" cellspacing="0" cellpadding="8">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Measure</th>
                    <th>Qty</th>
                    <th>Unit Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="invoiceBody"></tbody>
        </table>

        <h3 style="text-align:right;margin-top:10px;">
            Total: <span id="invoiceTotal"></span>
        </h3>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ================= ADD ROW =================
            document.querySelector('.addOrder').addEventListener('click', function() {

                let row = `
        <tr>
            <td><input type="text" class="form-control product_name"></td>
            <td>
                <input type="text" class="form-control measure_label"
                       placeholder="eg: 1kg, 500g, 2pcs">
            </td>
            <td><input type="number" step="0.001" class="form-control quantity"></td>
            <td><input type="number" step="0.01" class="form-control unit_price"></td>
            <td><input type="number" step="0.01" class="form-control subtotal" readonly></td>
            <td>
                <button type="button" class="btn btn-danger btn-sm removeOrder"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        `;

                document.querySelector('#orderTable tbody')
                    .insertAdjacentHTML('beforeend', row);
            });

            // ================= REMOVE ROW =================
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('removeOrder')) {
                    e.target.closest('tr').remove();
                }
            });

            // ================= LABEL â†’ AUTO QTY =================
            document.addEventListener('input', function(e) {

                if (!e.target.classList.contains('measure_label')) return;

                let row = e.target.closest('tr');
                let label = e.target.value.toLowerCase();
                let qty = 0;

                // Weight
                let kg = label.match(/([\d.]+)\s*kg/);
                let g = label.match(/([\d.]+)\s*(g|gm)/);
                let lb = label.match(/([\d.]+)\s*(lb|pound)/);

                if (kg) qty += parseFloat(kg[1]);
                if (g) qty += parseFloat(g[1]) / 1000;
                if (lb) qty += parseFloat(lb[1]) * 0.453592;

                // Liquid
                let l = label.match(/([\d.]+)\s*(l|ltr)/);
                let ml = label.match(/([\d.]+)\s*ml/);

                if (l) qty += parseFloat(l[1]);
                if (ml) qty += parseFloat(ml[1]) / 1000;

                // Pieces
                let pcs = label.match(/([\d.]+)\s*(pcs|pc|piece)/);
                if (pcs) qty += parseFloat(pcs[1]);

                if (qty > 0) {
                    row.querySelector('.quantity').value = parseFloat(qty.toFixed(3));
                    calculateSubtotal(row);
                }
            });

            // ================= QTY OR PRICE â†’ SUBTOTAL =================
            document.addEventListener('input', function(e) {

                if (
                    e.target.classList.contains('quantity') ||
                    e.target.classList.contains('unit_price')
                ) {
                    let row = e.target.closest('tr');
                    calculateSubtotal(row);
                }
            });

            // ================= SUBTOTAL FUNCTION =================
            function calculateSubtotal(row) {
                let qty = parseFloat(row.querySelector('.quantity').value) || 0;
                let price = parseFloat(row.querySelector('.unit_price').value) || 0;

                if (qty > 0 && price > 0) {
                   row.querySelector('.subtotal').value = parseFloat((qty * price).toFixed(2));
                } else {
                    row.querySelector('.subtotal').value = '';
                }
            }

        });
    </script>

    <script>
        document.getElementById('printInvoice').addEventListener('click', function() {

            /* ================= USER DETAILS ================= */
            document.getElementById('inv_name').innerText =
                document.querySelector('input[name="customer_name"]').value || '';

            document.getElementById('inv_phone').innerText =
                document.querySelector('input[name="customer_phone"]').value || '';

            document.getElementById('inv_order_number').innerText =
                document.querySelector('input[name="order_number"]').value || '';

            document.getElementById('inv_address').innerText =
                document.querySelector('input[name="customer_address"]').value || '';
            document.getElementById('inv_note').innerText =
                document.querySelector('input[name="note"]').value || '';

            /* ================= CURRENT DATE ================= */
            let today = new Date();
            let formattedDate = today.toLocaleDateString('en-GB', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            document.getElementById('inv_date').innerText = formattedDate;

            /* ================= LOGO ================= */
            document.getElementById('inv_logo').src =
                "{{ asset('assets/images/' . $gs->logo) }}";

            /* ================= ORDER ITEMS ================= */
            let tbody = document.getElementById('invoiceBody');
            tbody.innerHTML = '';
            let total = 0;

            document.querySelectorAll('#orderTable tbody tr').forEach(row => {

                let product = row.querySelector('.product_name')?.value || '';
                let label = row.querySelector('.measure_label')?.value || '';
                let qty = parseFloat(row.querySelector('.quantity')?.value) || 0;
                let price = parseFloat(row.querySelector('.unit_price')?.value) || 0;
                let subtotal = parseFloat(row.querySelector('.subtotal')?.value) || 0;

                if (product !== '') {
                    total += subtotal;

                    tbody.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${product}</td>
                    <td>${label}</td>
					<td>${parseFloat(qty.toFixed(3))}</td>
                   <td>${parseFloat(price.toFixed(2))}</td>
					<td>${parseFloat(subtotal.toFixed(2))}</td>
                </tr>
            `);
                }
            });

            document.getElementById('invoiceTotal').innerText = total.toFixed(2);

            /* ================= OPEN NEW WINDOW ================= */
            let win = window.open('', '', 'width=900,height=650');

            win.document.write(`
        <html>
        <head>
            <title>Order Invoice</title>
            <style>
                body { font-family: Arial; padding: 20px; }
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #000; padding: 8px; text-align: center; }
            </style>
        </head>
        <body>
            ${document.getElementById('invoiceArea').innerHTML}
        </body>
        </html>
    `);

            win.document.close();
            win.focus();
            win.print(); // Save as PDF
        });
    </script>
@endpush
