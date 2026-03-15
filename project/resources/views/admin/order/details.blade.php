@extends('layouts.admin')

@section('styles')
    <style type="text/css">
        .order-table-wrap table#example2 {
            margin: 10px 20px;
        }
    </style>
@endsection


@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Order Details') }} <a class="add-btn" href="javascript:history.back();"><i
                                class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Orders') }}</a>
                        </li>
                        <li>
                            <a href="javascript:;">{{ __('Order Details') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="order-table-wrap">
            @include('alerts.admin.form-both')
            @include('alerts.form-success')
            <div class="row">

                <div class="col-lg-6">
                    <div class="special-box">
                        <div class="heading-area">
                            <h4 class="title">
                                {{ __('Order Details') }}
                            </h4>
                        </div>
                        <div class="table-responsive-sm">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th class="45%" width="45%">{{ __('Order ID') }}</th>
                                        <td width="10%">:</td>
                                        <td class="45%" width="45%">{{ $order->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Total Product') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{ $order->totalQty }}</td>
                                    </tr>
                                    @if ($order->shipping_title != null && $order->is_shipping == 0)
                                        <tr>
                                            <th width="45%">{{ __('Shipping Method') }}</th>
                                            <td width="10%">:</td>
                                            <td width="45%">{{ $order->shipping_title }}</td>
                                        </tr>
                                    @endif

                                    @if ($order->shipping_cost != 0)
                                        <tr>
                                            <th width="45%">{{ __('Shipping Cost') }}</th>
                                            <td width="10%">:</td>
                                            <td width="45%">
                                                {{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost, $order->currency_sign) }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($order->tax != 0)
                                        <tr>
                                            <th width="45%">{{ __('Tax :') }}</th>
                                            <td width="10%">:</td>
                                            <td width="45%">
                                                {{ \PriceHelper::showOrderCurrencyPrice($order->tax / $order->currency_value, $order->currency_sign) }}
                                            </td>
                                        </tr>
                                    @endif

                                    @if ($order->packing_title != null && $order->is_shipping == 0)
                                        <tr>
                                            <th width="45%">{{ __('Packaging Method') }}</th>
                                            <td width="10%">:</td>
                                            <td width="45%">{{ $order->packing_title }}</td>
                                        </tr>
                                    @endif


                                    @if ($order->wallet_price != 0)
                                        <tr>
                                            <th width="45%">{{ __('Paid From Wallet') }}</th>
                                            <td width="10%">:</td>
                                            <td width="45%">
                                                {{ \PriceHelper::showOrderCurrencyPrice($order->wallet_price * $order->currency_value, $order->currency_sign) }}
                                            </td>
                                        </tr>

                                        @if ($order->method != 'Wallet')
                                            <tr>
                                                <th width="45%">{{ $order->method }}</th>
                                                <td width="10%">:</td>
                                                <td width="45%">
                                                    {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount * $order->currency_value, $order->currency_sign) }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endif

                                    <tr>
                                        <th width="45%">{{ __('Total Cost') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">
                                            {{ \PriceHelper::showOrderCurrencyPrice(
                                                ($order->pay_amount + $order->wallet_price) * $order->currency_value,
                                                $order->currency_sign,
                                            ) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Ordered Date') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{ date('d-M-Y H:i:s a', strtotime($order->created_at)) }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Payment Method') }}</th>
                                        <td width="10%">:</td>
                                        <td width="45%">{{ $order->method }}</td>
                                    </tr>

                                    @if ($order->method != 'Cash On Delivery' && $order->method != 'Wallet')
                                        @if ($order->method == 'Stripe')
                                            <tr>
                                                <th width="45%">{{ $order->method }} {{ __('Charge ID') }}</th>
                                                <td width="10%">:</td>
                                                <td width="45%">{{ $order->charge_id }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <th width="45%">{{ $order->method }} {{ __('Transaction ID') }}</th>
                                            <td width="10%">:</td>
                                            <td width="45%">{{ $order->txnid }}</td>
                                        </tr>
                                    @endif


                                    <th width="45%">{{ __('Payment Status') }}</th>
                                    <th width="10%">:</th>

                                    @if ($order->payment_status == 'Pending')
                                        <td><span class='badge badge-danger'>Unpaid</span></td>
                                    @else
                                        <td><span class='badge badge-success'>Paid</span></td>
                                    @endif

                                    @if (!empty($order->order_note))
                                        <th width="45%">{{ __('Order Note') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{ $order->order_note }}</td>
                                    @endif
                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                    @if ($order->tracks->count() > 0)
                                        <tr>
                                            <th width="45%">{{ __('Track Note') }} </th>
                                            <th width="10%">:</th>
                                            <td width="45%">

                                                @foreach ($order->tracks as $track)
                                                    @if ($track->title == 'Completed')
                                                        <span class="badge badge-success">{{ $track->text }}</span><i
                                                            class="fa fa-arrow-right" aria-hidden="true"></i>
                                                    @elseif($track->title == 'Pending')
                                                        <span class="badge badge-warning">{{ $track->text }}</span><i
                                                            class="fa fa-arrow-right" aria-hidden="true"></i>
                                                    @elseif($track->title == 'Hold')
                                                        <span class="badge badge-secondary">{{ $track->text }}</span><i
                                                            class="fa fa-arrow-right" aria-hidden="true"></i>
                                                    @elseif($track->title == 'Processing')
                                                        <span class="badge badge-info">{{ $track->text }}</span><i
                                                            class="fa fa-arrow-right" aria-hidden="true"></i>
                                                    @elseif($track->title == 'on delivery')
                                                        <span class="badge badge-primary">{{ $track->text }}</span><i
                                                            class="fa fa-arrow-right" aria-hidden="true"></i>
                                                    @elseif($track->title == 'Cancelled')
                                                        <span class="badge badge-danger">{{ $track->text }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        <div class="footer-area d-flex justify-content-between">
                            <a href="{{ route('admin-order-invoice', $order->id) }}" class="mybtn1"><i
                                    class="fas fa-eye"></i> {{ __('View Invoice') }}</a>
                            <a href="javascript:;" data-href="{{ route('admin-order-edit', $order->id) }}"
                                class="delivery mybtn1" data-toggle="modal" data-target="#modal1">Change Delivery Status
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="special-box">
                        <div class="heading-area">
                            <h4 class="title">
                                {{ __('Billing Details') }}
                                <a class="f15" href="javascript:;" data-toggle="modal"
                                    data-target="#billing-details-edit"><i
                                        class="fas fa-edit"></i>{{ __('Edit') }}</a>
                            </h4>
                        </div>
                        <div class="table-responsive-sm">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th width="45%">{{ __('Name') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{ $order->customer_name }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Email') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{ $order->customer_email ?? 'Empty' }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Phone') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{ $order->customer_phone ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Address') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{ $order->customer_address ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Country') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{ $order->customer_country ?? '' }}</td>
                                    </tr>
                                    @if ($order->customer_state != null)
                                        <tr>
                                            <th width="45%">{{ __('State') }}</th>
                                            <th width="10%">:</th>
                                            <td width="45%">{{ $order->customer_state ?? '' }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th width="45%">{{ __('City') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{ $order->customer_city ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th width="45%">{{ __('Postal Code') }}</th>
                                        <th width="10%">:</th>
                                        <td width="45%">{{ $order->customer_zip ?? '' }}</td>
                                    </tr>
                                    @if ($order->coupon_code != null)
                                        <tr>
                                            <th width="45%">{{ __('Coupon Code') }}</th>
                                            <th width="10%">:</th>
                                            <td width="45%">{{ $order->coupon_code ?? '' }}</td>
                                        </tr>
                                    @endif
                                    @if ($order->coupon_discount != null)
                                        <tr>
                                            <th width="45%">{{ __('Coupon Discount') }}</th>
                                            <th width="10%">:</th>
                                            @if ($gs->currency_format == 0)
                                                <td width="45%">
                                                    {{ $order->currency_sign }}{{ $order->coupon_discount }}</td>
                                            @else
                                                <td width="45%">
                                                    {{ $order->coupon_discount }}{{ $order->currency_sign }}</td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if ($order->affilate_user != null)
                                        <tr>
                                            <th width="45%">{{ __('Affilate User') }}</th>
                                            <th width="10%">:</th>
                                            <td width="45%">
                                                @if (App\Models\User::where('id', $order->affilate_user)->exists())
                                                    {{ App\Models\User::where('id', $order->affilate_user)->first()->name }}
                                                @else
                                                    {{ __('Deleted') }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($order->affilate_charge != null)
                                        <tr>
                                            <th width="45%">{{ __('Affilate Charge') }}</th>
                                            <th width="10%">:</th>
                                            <td width="45%">
                                                {{ \PriceHelper::showOrderCurrencyPrice(
                                                    $order->affilate_charge * $order->currency_value,
                                                    $order->currency_sign,
                                                ) }}
                                            </td>

                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if ($order->dp == 0)
                    <div class="col-lg-6">
                        <div class="special-box">
                            <div class="heading-area">
                                <h4 class="title">
                                    {{ __('Shipping Details') }}
                                    <a class="f15" href="javascript:;" data-toggle="modal"
                                        data-target="#shipping-details-edit"><i
                                            class="fas fa-edit"></i>{{ __('Edit') }}</a>
                                </h4>
                            </div>
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <tbody>
                                        @if ($order->shipping == 'pickup')
                                            <tr>
                                                <th width="45%"><strong>{{ __('Pickup Location') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">{{ $order->pickup_location }}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <th width="45%"><strong>{{ __('Name') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td>{{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Email') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">
                                                    {{ $order->shipping_email == null ? $order->customer_email : $order->shipping_email }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Phone') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">
                                                    {{ $order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Address') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">
                                                    {{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th width="45%"><strong>{{ __('Country') }}:</strong></th>
                                                <th width="10%">:</th>
                                                <td width="45%">
                                                    {{ $order->shipping_country == null ? $order->customer_country : $order->shipping_country }}
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- Multiple Note --}}
                <div class="col-lg-6">
                    <div class="special-box">
                        <div class="heading-area mb-0">
                            <h4 class="title">
                                {{ __('Multiple Note Details') }}

                            </h4>
                        </div>
                        <div class="p-3 pt-0">
                            <div class="mt-3">


                                <ul id="noteList" class="list-unstyled d-flex flex-column">
                                    @if ($order->multiple_note)
                                        @foreach (json_decode($order->multiple_note, true) as $note)
                                            <li style="text-align: left;  text-wrap: wrap; line-height: 20px; font-size: 15px;"
                                                class="badge badge-info mb-2 py-2">
                                                {{ $note['note'] }}
                                                <span class="text-white">({{ $note['time'] }} -> Note by:
                                                    {{ $note['user'] }})</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div>
                                    <form id="orderNoteForm" style="padding-top: 20px;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $order['id'] }}">
                                        <label>Add Note</label>
                                        <div class="input-group mb-3">
                                            <input autofocus required type="text" class="form-control"
                                                name="multiple_note[]" placeholder="Enter New note">
                                            <button class="btn btn-primary" type="submit">Add Note</button>
                                        </div>

                                        @error('multiple_note')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-search">
                        <label><span class="text-info">Product Search for Add Another Products</span></label>
                        <input type="text" id="product_search" class="form-control"
                            placeholder="Search product by name or code">
                        <div id="search_result" class="list-group mt-2"></div>
                    </div>
                </div>
            </div>

            <div id="order-items-wrapper">
                @include('admin.order.partials.order_items', ['order' => $order, 'cart' => $cart])
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="submit-loader">
                    <img src="{{ asset('assets/images/' . $gs->admin_loader) }}" alt="">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('scripts')
    <script>
        $(document).on('submit', '#orderNoteForm', function(e) {
            console.log('submit');

            e.preventDefault();

            let form = $(this);

            // trim input
            let noteInput = form.find('input[name="multiple_note[]"]');
            let trimmedValue = noteInput.val().trim();

            if (trimmedValue === '') {
                toastr.warning("Note cannot be empty !");
                return;
            }

            noteInput.val(trimmedValue);

            $.ajax({
                url: "{{ route('admin-order-mulitple-note') }}",
                type: "POST",
                data: form.serialize(),
                success: function(res) {

                    if (res.status) {

                        $('#noteList').append(`
                    <li style="text-align:left; line-height:20px; text-wrap: wrap; font-size: 15px;"
                        class="badge badge-info d-inline-block mb-2 py-2">
                        ${res.note.note}
                        <span class="text-white">
                            (${res.note.time} - Note by: ${res.note.user})
                        </span>
                    </li>
                `);

                        form[0].reset();
                        // toastr.success('Note added Successfully !');
                    }
                },
                error: function() {
                    // toastr.error('Something went wrong');
                }
            });
        });
    </script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        let orderId = '{{ $order->id }}';

        $('#product_search').keyup(function() {
            let keyword = $(this).val();

            if (keyword.length < 2) {
                $('#search_result').html('');
                return;
            }

            $.get('{{ route('admin.order.product_search') }}', {
                keyword: keyword
            }, function(res) {
                let html = '';

                if (res.length === 0) {
                    html = `<div class="list-group-item">No product found</div>`;
                } else {
                    res.forEach(product => {
                        html += `
                        <a href="javascript:;" class="list-group-item list-group-item-action select-product"
                           data-id="${product.id}">
                           <strong>${product.name}</strong> ${product.sku ? '(' + product.sku + ')' : ''}
                        </a>
                    `;
                    });
                }

                $('#search_result').html(html);
            });
        });

        $(document).on('click', '.select-product', function() {
            let productId = $(this).data('id');

            $.post('{{ url('admin/order') }}/' + orderId + '/add-product', {
                product_id: productId
            }, function(res) {
                if (res.status) {
                    $('#order-items-wrapper').html(res.html);
                    $('#search_result').html('');
                    $('#product_search').val('');
                }
            }).fail(function(xhr) {
                alert(xhr.responseJSON?.message || 'Something went wrong while adding product.');
            });
        });

        $(document).on('click', '.remove-item', function() {
            let productId = $(this).data('product-id');
            let orderId = $(this).data('order-id');

            $.ajax({
                url: '{{ url('admin/order') }}/' + orderId + '/remove-product/' + productId,
                type: 'DELETE',
                success: function(res) {
                    if (res.status) {
                        $('#order-items-wrapper').html(res.html);
                    }
                },
                error: function(xhr) {
                    alert(xhr.responseJSON?.message || 'Something went wrong while removing product.');
                }
            });
        });
    </script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        let qtyTimer;

        $(document).on('input', '.update_qty', function() {
            let el = $(this);

            clearTimeout(qtyTimer);

            qtyTimer = setTimeout(function() {
                let qty = parseInt(el.val());
                let productId = el.data('product-id');
                let orderId = el.data('order-id');

                if (!qty || qty < 1) {
                    qty = 1;
                    el.val(1);
                }

                $.post('{{ url('admin/order') }}/' + orderId + '/update-product-qty', {
                    product_id: productId,
                    qty: qty
                }, function(res) {
                    if (res.status) {
                        $('#order-items-wrapper').html(res.html);
                    }
                }).fail(function(xhr) {
                    alert(xhr.responseJSON?.message ||
                        'Something went wrong while updating quantity.');
                });
            }, 400);
        });
    </script>
@endsection
