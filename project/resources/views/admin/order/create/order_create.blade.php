@extends('layouts.admin')
@section('title', 'Create Order')
@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">Create An Order</h4>
                </div>
            </div>
        </div>

        <div class="product-area">
            <form action="{{ route('admin-store-orders') }}" method="POST">
                @csrf
                <div class="row p-3">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-12 mx-auto">
                                <div class="form-group">
                                    <label class="form-label">Search Customer <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="search_customer"
                                        placeholder="Search by name or mobile phone">
                                    <small class="text-danger d-none" id="customer_not_found">
                                        Customer does not exist
                                    </small>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" id="customer_id" name="customer_id">

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Customer Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Customer Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer_phone" name="customer_phone" required>
                                    <span id="phoneFeedback" class="small text-danger"></span>
                                    @error('customer_phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Customer Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="customer_address" name="customer_address" required>
                                    @error('customer_address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="pos-surface">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-grouop">
                                        <label class="form-label">Product</label>
                                        <input type="text" class="form-control" name="product_code"
                                            placeholder="Product Code">
                                        <div id="variation_box" class="border mt-1 p-2 d-none"></div>
                                        <small class="text-danger d-none" id="barcode_error"></small>
                                    </div>
                                </div>
                            </div>

                            {{-- Cart / Table Area --}}
                            <div class="pos-blank mt-4">
                                <table class="table table-bordered table-striped" id="pos_table">
                                    <thead>
                                        <tr>
                                            <th>SKU</th>
                                            <th>Product</th>
                                            <th>Qty / Unit</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pos_tbody">
                                        <tr id="empty_row">
                                            <td colspan="6" class="text-center">No products added!</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT PANEL --}}
                    <div class="col-lg-4">
                        <div class="card pos-side">
                            <div class="card-body">

                                {{-- Discount --}}
                                <div class="mb-3">
                                    <div class="fw-semibold">Discount Details</div>
                                    <label class="form-label mt-2">Discount Amount</label>
                                    <input type="number" class="form-control" value="0" name="discount_amount"
                                        id="discount_amount">
                                </div>

                                {{-- Totals --}}
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold"><b>Subtotal: </b></span>
                                    <span class="fw-semibold" id="subtotal">0</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold"><b>Discount: </b></span>
                                    <span class="fw-semibold" id="discount">0</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-bold"><b>Total: </b></span>
                                    <span class="fw-semibold" id="total">0</span>
                                </div>

                                <hr>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <div class="accordion" id="accordionExample">
                                            <div class="card">
                                                <div class="" id="headingTwo">
                                                    <h2 class="mb-0">
                                                        <button class="btn btn-link btn-block text-left collapsed"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapseTwo" aria-expanded="false"
                                                            aria-controls="collapseTwo">
                                                            Have a Coupon Code?
                                                        </button>
                                                    </h2>
                                                </div>
                                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                                    data-parent="#accordionExample">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter coupon code" name="coupon_code"
                                                            id="coupon_code">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-primary" type="button"
                                                                id="apply_coupon_btn">Apply</button>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="coupon_id" id="coupon_id">
                                                    <input type="hidden" name="coupon_discount" id="coupon_discount" value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Select Area <span class="text-danger">*</span></label>
                                            <select class="form-control" name="shipping_area" id="area">
                                                <option selected disabled>Select</option>
                                                @foreach ($shippings as $shipping)
                                                    <option value="{{ $shipping->price }}">{{ $shipping->title }} -
                                                        {{ $shipping->subtitle }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Payment --}}
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="form-label">Payment Type</label>
                                            <select class="form-control" name="payment_method" required>
                                                <option value="Cash On Delivery" selected>Cash on Delivery</option>
                                                <option value="card">Card</option>
                                                <option value="bkash">Bkash</option>
                                            </select>
                                            @error('payment_method')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="form-group">
                                            <label class="form-label">Total Bill</label>
                                            <input type="number" name="total_bill" class="form-control bg-light"
                                                id="total-bill" value="0" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="form-group">
                                            <label class="form-label">Paid Amount</label>
                                            <input type="number" name="paid_amount" id="paid-amount"
                                                class="form-control" value="0">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 mb-3">
                                        <div class="form-group">
                                            <label class="form-label">Change Amount</label>
                                            <input type="number" name="change_amount" id="change-amount"
                                                class="form-control bg-light" value="0" readonly>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label class="form-label">Courier <span class="text-danger">*</span></label>
                                            <select class="form-control" name="courier_service" required>
                                                <option selected disabled>Select</option>
                                                <option value="steadFast-courier">Steadfast Courier</option>
                                                <option value="pathao-courier">Pathao Courier</option>
                                            </select>
                                            @error('courier_service')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-warning w-100 fw-semibold">
                                            Create Order
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="create_customer_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin-create-customer') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="modal_customer_name">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="customer_name" id="modal_customer_name"
                                placeholder="Enter customer name">
                        </div>
                        <div class="form-group">
                            <label for="modal_customer_email">Email (Optional)</label>
                            <input type="email" class="form-control" name="customer_email" id="modal_customer_email"
                                placeholder="Enter customer email">
                        </div>
                        <div class="form-group">
                            <label for="modal_customer_phone">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="customer_phone" id="modal_customer_phone"
                                placeholder="Enter customer phone">
                        </div>
                        <div class="form-group">
                            <label for="modal_customer_address">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="customer_address" id="modal_customer_address"
                                placeholder="Enter customer address"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // ─── CUSTOMER SEARCH ───────────────────────────────────────────────────────
    let timer = null;

    $('#search_customer').on('keyup', function () {
        clearTimeout(timer);
        let query = $(this).val().trim();

        if (query.length < 3) {
            resetCustomerFields();
            return;
        }

        timer = setTimeout(function () {
            $.ajax({
                url: "{{ route('admin-customer-search') }}",
                type: "GET",
                data: { search: query },
                success: function (res) {
                    if (res.status === 'found') {
                        $('#customer_not_found').addClass('d-none');
                        $('#customer_id').val(res.data.id);
                        $('#customer_name').val(res.data.name);
                        $('#customer_phone').val(res.data.phone);
                        $('#customer_address').val(res.data.address);
                    } else {
                        resetCustomerFields();
                        $('#customer_not_found').removeClass('d-none');
                    }
                }
            });
        }, 400);
    });

    function resetCustomerFields() {
        $('#customer_id').val('');
        $('#customer_name').val('');
        $('#customer_phone').val('');
        $('#customer_address').val('');
        $('#customer_not_found').addClass('d-none');
    }

    // ─── CART ──────────────────────────────────────────────────────────────────
    let cart = {};
    let barcodeTimer = null;
    let barcodeBuffer = "";
    let couponDiscount = 0;

    // Barcode / product code input
    $('input[name="product_code"]').on('input', function () {
        clearTimeout(barcodeTimer);
        barcodeBuffer = $(this).val();

        barcodeTimer = setTimeout(() => {
            if (barcodeBuffer.length < 2) return;
            fetchProduct(barcodeBuffer);
            $(this).val('');
            barcodeBuffer = '';
        }, 500);
    });

    function fetchProduct(code) {
        $('#barcode_error').addClass('d-none').text('');

        $.get("{{ route('admin-get-product') }}", { code }, function (res) {
            if (!res.success) {
                $('#barcode_error').removeClass('d-none').text('Product not found!');
                return;
            }
            addToCart(res.product);
        });
    }

    // ── Helper: effective qty (gram → divide by 1000) ──────────────────────────
    function effectiveQty(item) {
        return item.unit === 'gram' ? item.qty / 1000 : item.qty;
    }

    // ── Helper: row subtotal ───────────────────────────────────────────────────
    function rowSubtotal(item) {
        return effectiveQty(item) * item.price;
    }

    // ── ADD TO CART ────────────────────────────────────────────────────────────
    function addToCart(product) {
        let key = product.id;

        if (cart[key]) {
            // already in cart: bump qty by 1 (works for pc; for kg/gram user can edit)
            cart[key].qty += cart[key].unit === 'pc' ? 1 : 0;
        } else {
            cart[key] = {
                key        : key,
                product_id : product.id,
                code       : product.code,
                name       : product.name,
                price      : parseFloat(product.price),
                qty        : 1,
                unit       : 'pc'
            };
        }

        renderCart();
    }

    // ── REMOVE ─────────────────────────────────────────────────────────────────
    $(document).on('click', '.remove-item', function () {
        delete cart[$(this).data('key')];
        renderCart();
    });

    // ── QTY CHANGE — NO full re-render ─────────────────────────────────────────
    $(document).on('change', '.qty', function () {
        let key = $(this).data('key');
        let val = parseFloat($(this).val());

        // Fallback for invalid input
        if (isNaN(val) || val <= 0) {
            val = cart[key].unit === 'pc' ? 1 : 0.1;
        }

        cart[key].qty = val;
        $(this).val(val);

        let rs = rowSubtotal(cart[key]);

        // Update hidden line_total
        $(this).closest('tr').find('.hidden-line-total').val(rs.toFixed(2));

        // Update visible subtotal cell (6th td = index 5, but hidden inputs
        // are INSIDE the first td now, so td order: sku=0 name=1 qty=2 price=3 subtotal=4 action=5)
        $(this).closest('tr').find('.row-subtotal').text(rs.toFixed(2));

        calculateTotals();
    });

    // ── UNIT CHANGE — NO full re-render ───────────────────────────────────────
    $(document).on('change', '.unit-select', function () {
        let key  = $(this).data('key');
        let unit = $(this).val();
        cart[key].unit = unit;

        let qtyInput = $(this).closest('td').find('.qty');

        if (unit === 'pc') {
            cart[key].qty = 1;
            qtyInput.attr({ min: '1', step: '1' }).val(1);
        } else if (unit === 'kg') {
            cart[key].qty = 1;
            qtyInput.attr({ min: '0.001', step: '0.001' }).val(1);
        } else if (unit === 'gram') {
            cart[key].qty = 500;
            qtyInput.attr({ min: '1', step: '1' }).val(500);
        }

        let rs = rowSubtotal(cart[key]);
        $(this).closest('tr').find('.hidden-line-total').val(rs.toFixed(2));
        $(this).closest('tr').find('.row-subtotal').text(rs.toFixed(2));

        calculateTotals();
    });

    // ── RENDER CART (only called on add / remove) ──────────────────────────────
    function renderCart() {
        let tbody = $('#pos_tbody');
        tbody.html('');

        if ($.isEmptyObject(cart)) {
            tbody.html('<tr><td colspan="6" class="text-center">No products added!</td></tr>');
            calculateTotals(0);
            return;
        }

        let subtotal = 0;

        $.each(cart, function (_, item) {
            let rs = rowSubtotal(item);
            subtotal += rs;

            let isDecimal = (item.unit !== 'pc');
            let minVal    = item.unit === 'gram' ? '1'     : (isDecimal ? '0.001' : '1');
            let stepVal   = item.unit === 'gram' ? '1'     : (isDecimal ? '0.001' : '1');

            tbody.append(`
                <tr>
                    <td>
                        ${item.code}
                        <input type="hidden" name="products[${item.key}][product_id]"  value="${item.product_id}" class="hidden-product-id">
                        <input type="hidden" name="products[${item.key}][unit_price]"  value="${item.price}">
                        <input type="hidden" name="products[${item.key}][line_total]"  value="${rs.toFixed(2)}" class="hidden-line-total">
                        <input type="hidden" name="products[${item.key}][unit]" value="${item.unit}">

                    </td>
                    <td>${item.name}</td>
                    <td>
                        <select class="form-control form-control-sm unit-select mb-1" data-key="${item.key}">
                            <option value="pc"   ${item.unit === 'pc'   ? 'selected' : ''}>PC</option>
                            <option value="kg"   ${item.unit === 'kg'   ? 'selected' : ''}>KG</option>
                            <option value="gram" ${item.unit === 'gram' ? 'selected' : ''}>Gram</option>
                        </select>
                        <input type="number"
                            min="${minVal}"
                            step="${stepVal}"
                            class="form-control form-control-sm qty"
                            name="products[${item.key}][qty]"
                            data-key="${item.key}"
                            value="${item.qty}">
                    </td>
                    <td>${item.price.toFixed(2)}</td>
                    <td class="row-subtotal">${rs.toFixed(2)}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm remove-item" data-key="${item.key}">X</button>
                    </td>
                </tr>
            `);
        });

        calculateTotals(subtotal);
    }

    // ── TOTALS ─────────────────────────────────────────────────────────────────
    function getSubtotal() {
        let sum = 0;
        $.each(cart, function (_, item) {
            sum += rowSubtotal(item); // gram-aware
        });
        return sum;
    }

    function calculateTotals(forceSubtotal = null) {
        let subtotal       = (forceSubtotal !== null) ? forceSubtotal : getSubtotal();
        let manualDiscount = parseFloat($('#discount_amount').val()) || 0;
        let totalDiscount  = manualDiscount + couponDiscount;

        let total = Math.max(subtotal - totalDiscount, 0);

        $('#subtotal').text(subtotal.toFixed(2));
        $('#discount').text(totalDiscount.toFixed(2));
        $('#total').text(total.toFixed(2));

        let areaAmount = parseFloat($('#area').val()) || 0;
        let finalTotal = total + areaAmount;

        $('#total-bill').val(finalTotal.toFixed(2));

        let paidAmount   = parseFloat($('#paid-amount').val()) || 0;
        let changeAmount = paidAmount - finalTotal;
        $('#change-amount').val(changeAmount.toFixed(2));
    }

    $('#discount_amount').on('input', function () { calculateTotals(); });
    $('#paid-amount').on('input',     function () { calculateTotals(); });
    $('#area').on('change',           function () { calculateTotals(); });

    // ── COUPON ─────────────────────────────────────────────────────────────────
    $('#apply_coupon_btn').on('click', function () {
        let code     = $('#coupon_code').val();
        let subtotal = getSubtotal();

        if (!code) { alert('Enter coupon code'); return; }

        $.ajax({
            url  : "{{ route('admin-apply-coupon') }}",
            type : "POST",
            data : {
                _token   : "{{ csrf_token() }}",
                code     : code,
                subtotal : subtotal
            },
            success: function (res) {
                if (!res.success) { alert(res.message); return; }

                couponDiscount = parseFloat(res.discount);
                $('#coupon_id').val(res.coupon_id);
                $('#coupon_discount').val(couponDiscount);

                alert(res.message);
                calculateTotals();
            }
        });
    });

    // ─── PHONE VALIDATION ──────────────────────────────────────────────────────
    const phoneRegex = /^(01[3-9]\d{8})$/;

    document.getElementById('customer_phone').addEventListener('input', function () {
        const phoneFeedback = document.getElementById('phoneFeedback');
        if (this.value === '') {
            phoneFeedback.textContent = '';
            phoneFeedback.className = 'small text-danger';
        } else if (!phoneRegex.test(this.value)) {
            phoneFeedback.textContent = 'Please enter a valid Bangladeshi phone number (e.g. 0171XXXXXXX)';
            phoneFeedback.className = 'small text-danger';
        } else {
            phoneFeedback.textContent = 'Valid phone number!';
            phoneFeedback.className = 'small text-success';
        }
    });

    document.getElementById('customer_phone').addEventListener('blur', function () {
        const phoneFeedback = document.getElementById('phoneFeedback');
        if (this.value === '') {
            phoneFeedback.textContent = 'Phone number is required';
            phoneFeedback.className = 'small text-danger';
        } else if (!phoneRegex.test(this.value)) {
            phoneFeedback.textContent = 'Please enter a valid Bangladeshi phone number (e.g. 0171XXXXXXX)';
            phoneFeedback.className = 'small text-danger';
        }
    });
</script>
@endpush
