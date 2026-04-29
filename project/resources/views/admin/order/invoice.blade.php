@extends('layouts.admin')

<style>
    .invoice-page {
        padding: 24px;
        background: #f9fafb;
        min-height: 100vh;
    }

    /* ── Card ── */
    .invoice-card {
        background: #fff;
        border: 0.5px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
    }

    /* ── Header ── */
    .invoice-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 28px;
        border-bottom: 0.5px solid #f0f1f3;
        background: #fafafa;
    }

    .invoice-header img {
        max-height: 48px;
        object-fit: contain;
    }

    .invoice-title-block h5 {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .invoice-title-block p {
        font-size: 13px;
        color: #6b7280;
        margin: 4px 0 0;
    }

    .print-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 18px;
        background: #1598a7;
        color: #fff;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .print-btn:hover {
        opacity: 0.88;
        color: #fff;
    }

    /* ── Meta Section ── */
    .invoice-meta {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
        border-bottom: 0.5px solid #f0f1f3;
    }

    .meta-box {
        padding: 20px 28px;
        border-right: 0.5px solid #f0f1f3;
    }

    .meta-box:last-child {
        border-right: none;
    }

    .meta-box-title {
        font-size: 11px;
        font-weight: 600;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 12px;
    }

    .meta-row {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .meta-item {
        font-size: 13px;
        color: #6b7280;
        line-height: 1.5;
    }

    .meta-item strong {
        color: #374151;
        font-weight: 500;
    }

    /* ── Table ── */
    .invoice-table-wrap {
        padding: 24px 28px;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .invoice-table thead tr {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .invoice-table thead th {
        padding: 11px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-align: left;
    }

    .invoice-table thead th:last-child {
        text-align: right;
    }

    .invoice-table tbody tr {
        border-bottom: 0.5px solid #f3f4f6;
        transition: background 0.15s;
    }

    .invoice-table tbody tr:hover {
        background: #fafafa;
    }

    .invoice-table tbody td {
        padding: 14px 16px;
        color: #374151;
        vertical-align: top;
    }

    .invoice-table tbody td:last-child {
        text-align: right;
        font-weight: 500;
    }

    .product-name-link {
        font-weight: 500;
        color: #1598a7;
        text-decoration: none;
    }

    .product-name-link:hover {
        text-decoration: underline;
    }

    .product-detail-row {
        font-size: 12px;
        color: #6b7280;
        margin: 3px 0 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .product-detail-row strong {
        color: #374151;
        font-weight: 500;
    }

    .color-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        display: inline-block;
        vertical-align: middle;
        border: 1px solid rgba(0, 0, 0, 0.1);
    }

    .discount-pill {
        font-size: 11px;
        font-weight: 600;
        background: #fff8f0;
        color: #b05f10;
        border: 0.5px solid #fcd34d;
        padding: 2px 7px;
        border-radius: 20px;
        margin-left: 6px;
    }

    /* ── Tfoot ── */
    .invoice-table tfoot tr td {
        padding: 10px 16px;
        font-size: 14px;
        border-top: 0.5px solid #f3f4f6;
    }

    .tfoot-label {
        color: #6b7280;
        font-weight: 400;
    }

    .tfoot-value {
        color: #111827;
        font-weight: 500;
        text-align: right;
    }

    .discount-row td {
        background: #fffdf5;
    }

    .discount-type-badge {
        font-size: 11px;
        font-weight: 600;
        background: #fff8f0;
        color: #b05f10;
        border: 0.5px solid #fcd34d;
        padding: 2px 8px;
        border-radius: 20px;
        margin-left: 6px;
    }

    .discount-value {
        color: #d97706 !important;
    }

    .badge-free {
        font-size: 11px;
        font-weight: 600;
        background: #e9faf3;
        color: #15803d;
        border: 0.5px solid #bbf7d0;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .grand-total-row td {
        background: #f0fbfc;
        border-top: 1.5px solid #1598a7 !important;
        padding-top: 14px !important;
        padding-bottom: 14px !important;
    }

    .grand-total-label {
        font-size: 15px;
        font-weight: 600;
        color: #111827 !important;
    }

    .grand-total-value {
        font-size: 16px;
        font-weight: 700;
        color: #15803d !important;
    }

    @media (max-width: 768px) {
        .invoice-meta {
            grid-template-columns: 1fr;
        }

        .meta-box {
            border-right: none;
            border-bottom: 0.5px solid #f0f1f3;
        }

        .invoice-table-wrap {
            padding: 16px;
        }

        .invoice-header {
            flex-wrap: wrap;
            gap: 12px;
        }
    }
</style>

@section('content')
    <div class="content-area invoice-page">

        {{-- Breadcrumb --}}
        <div class="mr-breadcrumb mb-4">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">
                        {{ __('Order Invoice') }}
                        <a class="add-btn" href="javascript:history.back();">
                            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                        </a>
                    </h4>
                    <ul class="links">
                        <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a href="{{ route('admin-orders-all') }}">{{ __('Orders') }}</a></li>
                        <li><a href="javascript:;">{{ __('Invoice') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="invoice-card">

            {{-- Header --}}
            <div class="invoice-header">
                <img src="{{ asset('assets/images/' . $gs->invoice_logo) }}" alt="Logo">
                <div class="invoice-title-block" style="text-align:center;">
                    <h5>{{ __('Invoice') }}</h5>
                    <p>#{{ sprintf("%'.08d", $order->id) }}</p>
                </div>
                <a class="print-btn" href="{{ route('admin-order-print', $order->id) }}" target="_blank">
                    <i class="fa fa-print"></i> {{ __('Print Invoice') }}
                </a>
            </div>

            {{-- Meta Info --}}
            <div class="invoice-meta">

                {{-- Order Details --}}
                <div class="meta-box">
                    <p class="meta-box-title">{{ __('Order Details') }}</p>
                    <div class="meta-row">
                        <span class="meta-item"><strong>{{ __('Invoice No') }}:</strong>
                            {{ sprintf("%'.08d", $order->id) }}</span>
                        <span class="meta-item"><strong>{{ __('Order Date') }}:</strong>
                            {{ date('d M Y, h:i A', strtotime($order->created_at)) }}</span>
                        <span class="meta-item"><strong>{{ __('Order ID') }}:</strong> {{ $order->order_number }}</span>
                        @if ($order->dp == 0)
                            <span class="meta-item"><strong>{{ __('Shipping') }}:</strong>
                                {{ $order->shippingMethod->title ?? 'N/A' }}</span>
                        @endif
                        <span class="meta-item"><strong>{{ __('Payment') }}:</strong> {{ $order->method }}</span>
                    </div>
                </div>

                {{-- Shipping Address --}}
                @if ($order->dp == 0)
                    <div class="meta-box">
                        <p class="meta-box-title">{{ __('Shipping Address') }}</p>
                        <div class="meta-row">
                            <span class="meta-item"><strong>{{ __('Name') }}:</strong>
                                {{ $order->shipping_name ?? $order->customer_name }}</span>
                            <span class="meta-item"><strong>{{ __('Address') }}:</strong>
                                {{ $order->shipping_address ?? $order->customer_address }}</span>
                            <span class="meta-item"><strong>{{ __('Phone') }}:</strong>
                                {{ $order->customer_phone ?? 'N/A' }}</span>
                            @if ($order->order_note)
                                <span class="meta-item"><strong>{{ __('Note') }}:</strong>
                                    {{ $order->order_note }}</span>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Billing Details --}}
                <div class="meta-box">
                    <p class="meta-box-title">{{ __('Billing Details') }}</p>
                    <div class="meta-row">
                        <span class="meta-item"><strong>{{ __('Branch') }}:</strong>
                            {{ $order->branch->name ?? 'N/A' }}</span>
                        <span class="meta-item"><strong>{{ __('Address') }}:</strong>
                            {{ $order->branch->address ?? 'N/A' }}</span>
                    </div>
                </div>

            </div>

            {{-- Products Table --}}
            <div class="invoice-table-wrap">
                <div class="table-responsive">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th style="width:40%">{{ __('Product') }}</th>
                                <th>{{ __('Details') }}</th>
                                <th>{{ __('Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach ($cart['items'] as $product)
                                <tr>
                                    <td>
                                        @if ($product['item']['user_id'] != 0)
                                            @php $user = App\Models\User::find($product['item']['user_id']); @endphp
                                            @if (isset($user))
                                                <a class="product-name-link" target="_blank"
                                                    href="{{ route('front.product', $product['item']['slug']) }}">
                                                    {{ $product['item']['name'] }}
                                                </a>
                                            @else
                                                <span style="font-weight:500;">{{ $product['item']['name'] }}</span>
                                            @endif
                                        @else
                                            <span style="font-weight:500;">{{ $product['item']['name'] }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($product['size'])
                                            <p class="product-detail-row">
                                                <strong>{{ __('Size') }}:</strong>
                                                {{ str_replace('-', ' ', $product['size']) }}
                                            </p>
                                        @endif
                                        @if ($product['color'])
                                            <p class="product-detail-row">
                                                <strong>{{ __('Color') }}:</strong>
                                                <span class="color-dot"
                                                    style="background:#{{ $product['color'] }};"></span>
                                            </p>
                                        @endif
                                        <p class="product-detail-row">
                                            <strong>{{ __('Price') }}:</strong>
                                            {{ \PriceHelper::showCurrencyPrice($product['item_price'] * $order->currency_value) }}
                                        </p>
                                        <p class="product-detail-row">
                                            <strong>{{ __('Qty') }}:</strong> {{ $product['qty'] }}
                                        </p>
                                        @if (!empty($product['keys']))
                                            @foreach (array_combine(explode(',', $product['keys']), explode(',', $product['values'])) as $key => $value)
                                                <p class="product-detail-row">
                                                    <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
                                                    {{ $value }}
                                                </p>
                                            @endforeach
                                        @endif
                                    </td>

                                    <td>
                                        {{ \PriceHelper::showCurrencyPrice($product['price'] * $order->currency_value) }}
                                        @if ($product['discount'] != 0)
                                            <span class="discount-pill">{{ $product['discount'] }}% Off</span>
                                        @endif
                                    </td>

                                    @php
                                        $subtotal += round(
                                            ($product['price'] / $order->currency_value) * $order->currency_value,
                                            2,
                                        );
                                    @endphp
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            {{-- Subtotal --}}
                            <tr>
                                <td colspan="2" class="tfoot-label">{{ __('Subtotal') }}</td>
                                <td class="tfoot-value">
                                    {{ \PriceHelper::showCurrencyPrice($subtotal * $order->currency_value) }}
                                </td>
                            </tr>

                            {{-- Delivery Charge --}}
                            @if ($order->shipping_cost != 0)
                                @php $price = round(($order->shipping_cost / $order->currency_value), 2); @endphp
                                @if (DB::table('shippings')->where('price', '=', $price)->count() > 0)
                                    <tr>
                                        <td colspan="2" class="tfoot-label">
                                            {{ DB::table('shippings')->where('price', '=', $price)->first()->title }}
                                        </td>
                                        <td class="tfoot-value">
                                            {{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost, $order->currency_sign) }}
                                        </td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td colspan="2" class="tfoot-label">{{ __('Delivery Charge') }}</td>
                                    <td class="tfoot-value"><span class="badge-free">Free</span></td>
                                </tr>
                            @endif

                            {{-- Packing --}}
                            @if ($order->packing_cost != 0)
                                @php $pprice = round(($order->packing_cost / $order->currency_value), 2); @endphp
                                @if (DB::table('packages')->where('price', '=', $pprice)->count() > 0)
                                    <tr>
                                        <td colspan="2" class="tfoot-label">
                                            {{ DB::table('packages')->where('price', '=', $pprice)->first()->title }}
                                        </td>
                                        <td class="tfoot-value">
                                            {{ \PriceHelper::showOrderCurrencyPrice($order->packing_cost, $order->currency_sign) }}
                                        </td>
                                    </tr>
                                @endif
                            @endif

                            {{-- Tax --}}
                            @if ($order->tax != 0)
                                <tr>
                                    <td colspan="2" class="tfoot-label">{{ __('Tax') }}</td>
                                    <td class="tfoot-value">
                                        {{ \PriceHelper::showOrderCurrencyPrice($order->tax / $order->currency_value, $order->currency_sign) }}
                                    </td>
                                </tr>
                            @endif

                            {{-- Discount --}}
                            @if ($order->coupon_discount != null || ($order->discount ?? 0) > 0)
                                <tr class="discount-row">
                                    <td colspan="2" class="tfoot-label">
                                        {{ __('Discount') }}
                                        <span class="discount-type-badge">
                                            @if ($order->discount_type == 'percent')
                                                % Off
                                            @elseif ($order->discount_type == 'amount')
                                                Fixed
                                            @elseif ($order->discount_type == 'loyalty_points')
                                                Points
                                            @elseif ($order->coupon_discount != null)
                                                Coupon
                                            @endif
                                        </span>
                                    </td>
                                    <td class="tfoot-value discount-value">
                                        −
                                        {{ \PriceHelper::showOrderCurrencyPrice($order->coupon_discount ?? $order->discount, $order->currency_sign) }}
                                    </td>
                                </tr>
                            @endif

                            {{-- Wallet --}}
                            @if ($order->wallet_price != 0)
                                <tr>
                                    <td colspan="2" class="tfoot-label">{{ __('Paid From Wallet') }}</td>
                                    <td class="tfoot-value">
                                        {{ \PriceHelper::showOrderCurrencyPrice($order->wallet_price * $order->currency_value, $order->currency_sign) }}
                                    </td>
                                </tr>
                                @if ($order->method != 'Wallet')
                                    <tr>
                                        <td colspan="2" class="tfoot-label">{{ $order->method }}</td>
                                        <td class="tfoot-value">
                                            {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount * $order->currency_value, $order->currency_sign) }}
                                        </td>
                                    </tr>
                                @endif
                            @endif@extends('layouts.admin')

                            <style>
                                .invoice-page {
                                    padding: 24px;
                                    background: #f9fafb;
                                    min-height: 100vh;
                                }

                                /* ── Card ── */
                                .invoice-card {
                                    background: #fff;
                                    border: 0.5px solid #e5e7eb;
                                    border-radius: 16px;
                                    overflow: hidden;
                                }

                                /* ── Header ── */
                                .invoice-header {
                                    display: flex;
                                    align-items: center;
                                    justify-content: space-between;
                                    padding: 20px 28px;
                                    border-bottom: 0.5px solid #f0f1f3;
                                    background: #fafafa;
                                }

                                .invoice-header img {
                                    max-height: 48px;
                                    object-fit: contain;
                                }

                                .invoice-title-block h5 {
                                    font-size: 18px;
                                    font-weight: 600;
                                    color: #111827;
                                    margin: 0;
                                }

                                .invoice-title-block p {
                                    font-size: 13px;
                                    color: #6b7280;
                                    margin: 4px 0 0;
                                }

                                .print-btn {
                                    display: inline-flex;
                                    align-items: center;
                                    gap: 7px;
                                    padding: 9px 18px;
                                    background: #1598a7;
                                    color: #fff;
                                    border-radius: 8px;
                                    font-size: 13px;
                                    font-weight: 500;
                                    text-decoration: none;
                                    transition: opacity 0.2s;
                                }

                                .print-btn:hover {
                                    opacity: 0.88;
                                    color: #fff;
                                }

                                /* ── Meta Section ── */
                                .invoice-meta {
                                    display: grid;
                                    grid-template-columns: repeat(3, 1fr);
                                    gap: 0;
                                    border-bottom: 0.5px solid #f0f1f3;
                                }

                                .meta-box {
                                    padding: 20px 28px;
                                    border-right: 0.5px solid #f0f1f3;
                                }

                                .meta-box:last-child {
                                    border-right: none;
                                }

                                .meta-box-title {
                                    font-size: 11px;
                                    font-weight: 600;
                                    color: #9ca3af;
                                    text-transform: uppercase;
                                    letter-spacing: 0.06em;
                                    margin-bottom: 12px;
                                }

                                .meta-row {
                                    display: flex;
                                    flex-direction: column;
                                    gap: 6px;
                                }

                                .meta-item {
                                    font-size: 13px;
                                    color: #6b7280;
                                    line-height: 1.5;
                                }

                                .meta-item strong {
                                    color: #374151;
                                    font-weight: 500;
                                }

                                /* ── Table ── */
                                .invoice-table-wrap {
                                    padding: 24px 28px;
                                }

                                .invoice-table {
                                    width: 100%;
                                    border-collapse: collapse;
                                    font-size: 14px;
                                }

                                .invoice-table thead tr {
                                    background: #f9fafb;
                                    border-bottom: 1px solid #e5e7eb;
                                }

                                .invoice-table thead th {
                                    padding: 11px 16px;
                                    font-size: 12px;
                                    font-weight: 600;
                                    color: #6b7280;
                                    text-transform: uppercase;
                                    letter-spacing: 0.05em;
                                    text-align: left;
                                }

                                .invoice-table thead th:last-child {
                                    text-align: right;
                                }

                                .invoice-table tbody tr {
                                    border-bottom: 0.5px solid #f3f4f6;
                                    transition: background 0.15s;
                                }

                                .invoice-table tbody tr:hover {
                                    background: #fafafa;
                                }

                                .invoice-table tbody td {
                                    padding: 14px 16px;
                                    color: #374151;
                                    vertical-align: top;
                                }

                                .invoice-table tbody td:last-child {
                                    text-align: right;
                                    font-weight: 500;
                                }

                                .product-name-link {
                                    font-weight: 500;
                                    color: #1598a7;
                                    text-decoration: none;
                                }

                                .product-name-link:hover {
                                    text-decoration: underline;
                                }

                                .product-detail-row {
                                    font-size: 12px;
                                    color: #6b7280;
                                    margin: 3px 0 0;
                                    display: flex;
                                    align-items: center;
                                    gap: 6px;
                                }

                                .product-detail-row strong {
                                    color: #374151;
                                    font-weight: 500;
                                }

                                .color-dot {
                                    width: 14px;
                                    height: 14px;
                                    border-radius: 50%;
                                    display: inline-block;
                                    vertical-align: middle;
                                    border: 1px solid rgba(0, 0, 0, 0.1);
                                }

                                .discount-pill {
                                    font-size: 11px;
                                    font-weight: 600;
                                    background: #fff8f0;
                                    color: #b05f10;
                                    border: 0.5px solid #fcd34d;
                                    padding: 2px 7px;
                                    border-radius: 20px;
                                    margin-left: 6px;
                                }

                                /* ── Tfoot ── */
                                .invoice-table tfoot tr td {
                                    padding: 10px 16px;
                                    font-size: 14px;
                                    border-top: 0.5px solid #f3f4f6;
                                }

                                .tfoot-label {
                                    color: #6b7280;
                                    font-weight: 400;
                                }

                                .tfoot-value {
                                    color: #111827;
                                    font-weight: 500;
                                    text-align: right;
                                }

                                .discount-row td {
                                    background: #fffdf5;
                                }

                                .discount-type-badge {
                                    font-size: 11px;
                                    font-weight: 600;
                                    background: #fff8f0;
                                    color: #b05f10;
                                    border: 0.5px solid #fcd34d;
                                    padding: 2px 8px;
                                    border-radius: 20px;
                                    margin-left: 6px;
                                }

                                .discount-value {
                                    color: #d97706 !important;
                                }

                                .badge-free {
                                    font-size: 11px;
                                    font-weight: 600;
                                    background: #e9faf3;
                                    color: #15803d;
                                    border: 0.5px solid #bbf7d0;
                                    padding: 3px 10px;
                                    border-radius: 20px;
                                }

                                .grand-total-row td {
                                    background: #f0fbfc;
                                    border-top: 1.5px solid #1598a7 !important;
                                    padding-top: 14px !important;
                                    padding-bottom: 14px !important;
                                }

                                .grand-total-label {
                                    font-size: 15px;
                                    font-weight: 600;
                                    color: #111827 !important;
                                }

                                .grand-total-value {
                                    font-size: 16px;
                                    font-weight: 700;
                                    color: #15803d !important;
                                }

                                @media (max-width: 768px) {
                                    .invoice-meta {
                                        grid-template-columns: 1fr;
                                    }

                                    .meta-box {
                                        border-right: none;
                                        border-bottom: 0.5px solid #f0f1f3;
                                    }

                                    .invoice-table-wrap {
                                        padding: 16px;
                                    }

                                    .invoice-header {
                                        flex-wrap: wrap;
                                        gap: 12px;
                                    }
                                }
                            </style>

                            @section('content')
                                <div class="content-area invoice-page">

                                    {{-- Breadcrumb --}}
                                    <div class="mr-breadcrumb mb-4">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h4 class="heading">
                                                    {{ __('Order Invoice') }}
                                                    <a class="add-btn" href="javascript:history.back();">
                                                        <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                                                    </a>
                                                </h4>
                                                <ul class="links">
                                                    <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                                                    </li>
                                                    <li><a href="{{ route('admin-orders-all') }}">{{ __('Orders') }}</a></li>
                                                    <li><a href="javascript:;">{{ __('Invoice') }}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="invoice-card">

                                        {{-- Header --}}
                                        <div class="invoice-header">
                                            <img src="{{ asset('assets/images/' . $gs->invoice_logo) }}" alt="Logo">
                                            <div class="invoice-title-block" style="text-align:center;">
                                                <h5>{{ __('Invoice') }}</h5>
                                                <p>#{{ sprintf("%'.08d", $order->id) }}</p>
                                            </div>
                                            <a class="print-btn" href="{{ route('admin-order-print', $order->id) }}"
                                                target="_blank">
                                                <i class="fa fa-print"></i> {{ __('Print Invoice') }}
                                            </a>
                                        </div>

                                        {{-- Meta Info --}}
                                        <div class="invoice-meta">

                                            {{-- Order Details --}}
                                            <div class="meta-box">
                                                <p class="meta-box-title">{{ __('Order Details') }}</p>
                                                <div class="meta-row">
                                                    <span class="meta-item"><strong>{{ __('Invoice No') }}:</strong>
                                                        {{ sprintf("%'.08d", $order->id) }}</span>
                                                    <span class="meta-item"><strong>{{ __('Order Date') }}:</strong>
                                                        {{ date('d M Y, h:i A', strtotime($order->created_at)) }}</span>
                                                    <span class="meta-item"><strong>{{ __('Order ID') }}:</strong>
                                                        {{ $order->order_number }}</span>
                                                    @if ($order->dp == 0)
                                                        <span class="meta-item"><strong>{{ __('Shipping') }}:</strong>
                                                            {{ $order->shippingMethod->title ?? 'N/A' }}</span>
                                                    @endif
                                                    <span class="meta-item"><strong>{{ __('Payment') }}:</strong>
                                                        {{ $order->method }}</span>
                                                </div>
                                            </div>

                                            {{-- Shipping Address --}}
                                            @if ($order->dp == 0)
                                                <div class="meta-box">
                                                    <p class="meta-box-title">{{ __('Shipping Address') }}</p>
                                                    <div class="meta-row">
                                                        <span class="meta-item"><strong>{{ __('Name') }}:</strong>
                                                            {{ $order->shipping_name ?? $order->customer_name }}</span>
                                                        <span class="meta-item"><strong>{{ __('Address') }}:</strong>
                                                            {{ $order->shipping_address ?? $order->customer_address }}</span>
                                                        <span class="meta-item"><strong>{{ __('Phone') }}:</strong>
                                                            {{ $order->customer_phone ?? 'N/A' }}</span>
                                                        @if ($order->order_note)
                                                            <span class="meta-item"><strong>{{ __('Note') }}:</strong>
                                                                {{ $order->order_note }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif

                                            {{-- Billing Details --}}
                                            <div class="meta-box">
                                                <p class="meta-box-title">{{ __('Billing Details') }}</p>
                                                <div class="meta-row">
                                                    <span class="meta-item"><strong>{{ __('Branch') }}:</strong>
                                                        {{ $order->branch->name ?? 'N/A' }}</span>
                                                    <span class="meta-item"><strong>{{ __('Address') }}:</strong>
                                                        {{ $order->branch->address ?? 'N/A' }}</span>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- Products Table --}}
                                        <div class="invoice-table-wrap">
                                            <div class="table-responsive">
                                                <table class="invoice-table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:40%">{{ __('Product') }}</th>
                                                            <th>{{ __('Details') }}</th>
                                                            <th>{{ __('Total') }}</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php $subtotal = 0; @endphp
                                                        @foreach ($cart['items'] as $product)
                                                            <tr>
                                                                <td>
                                                                    @if ($product['item']['user_id'] != 0)
                                                                        @php $user = App\Models\User::find($product['item']['user_id']); @endphp
                                                                        @if (isset($user))
                                                                            <a class="product-name-link" target="_blank"
                                                                                href="{{ route('front.product', $product['item']['slug']) }}">
                                                                                {{ $product['item']['name'] }}
                                                                            </a>
                                                                        @else
                                                                            <span
                                                                                style="font-weight:500;">{{ $product['item']['name'] }}</span>
                                                                        @endif
                                                                    @else
                                                                        <span
                                                                            style="font-weight:500;">{{ $product['item']['name'] }}</span>
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    @if ($product['size'])
                                                                        <p class="product-detail-row">
                                                                            <strong>{{ __('Size') }}:</strong>
                                                                            {{ str_replace('-', ' ', $product['size']) }}
                                                                        </p>
                                                                    @endif
                                                                    @if ($product['color'])
                                                                        <p class="product-detail-row">
                                                                            <strong>{{ __('Color') }}:</strong>
                                                                            <span class="color-dot"
                                                                                style="background:#{{ $product['color'] }};"></span>
                                                                        </p>
                                                                    @endif
                                                                    <p class="product-detail-row">
                                                                        <strong>{{ __('Price') }}:</strong>
                                                                        {{ \PriceHelper::showCurrencyPrice($product['item_price'] * $order->currency_value) }}
                                                                    </p>
                                                                    <p class="product-detail-row">
                                                                        <strong>{{ __('Qty') }}:</strong>
                                                                        {{ $product['qty'] }}
                                                                    </p>
                                                                    @if (!empty($product['keys']))
                                                                        @foreach (array_combine(explode(',', $product['keys']), explode(',', $product['values'])) as $key => $value)
                                                                            <p class="product-detail-row">
                                                                                <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong>
                                                                                {{ $value }}
                                                                            </p>
                                                                        @endforeach
                                                                    @endif
                                                                </td>

                                                                <td>
                                                                    {{ \PriceHelper::showCurrencyPrice($product['price'] * $order->currency_value) }}
                                                                    @if ($product['discount'] != 0)
                                                                        <span
                                                                            class="discount-pill">{{ $product['discount'] }}%
                                                                            Off</span>
                                                                    @endif
                                                                </td>

                                                                @php
                                                                    $subtotal += round(
                                                                        ($product['price'] / $order->currency_value) *
                                                                            $order->currency_value,
                                                                        2,
                                                                    );
                                                                @endphp
                                                            </tr>
                                                        @endforeach
                                                    </tbody>

                                                    <tfoot>
                                                        {{-- Subtotal --}}
                                                        <tr>
                                                            <td colspan="2" class="tfoot-label">{{ __('Subtotal') }}</td>
                                                            <td class="tfoot-value">
                                                                {{ \PriceHelper::showCurrencyPrice($subtotal * $order->currency_value) }}
                                                            </td>
                                                        </tr>

                                                        {{-- Delivery Charge --}}
                                                        @if ($order->shipping_cost != 0)
                                                            @php $price = round(($order->shipping_cost / $order->currency_value), 2); @endphp
                                                            @if (DB::table('shippings')->where('price', '=', $price)->count() > 0)
                                                                <tr>
                                                                    <td colspan="2" class="tfoot-label">
                                                                        Delivery Charge
                                                                        <small>({{ DB::table('shippings')->where('price', '=', $price)->first()->title }})</small>
                                                                    </td>
                                                                    <td class="tfoot-value">
                                                                        {{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost, $order->currency_sign) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @else
                                                            <tr>
                                                                <td colspan="2" class="tfoot-label">
                                                                    {{ __('Delivery Charge') }}</td>
                                                                <td class="tfoot-value"><span class="badge-free">Free</span>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        {{-- Packing --}}
                                                        @if ($order->packing_cost != 0)
                                                            @php $pprice = round(($order->packing_cost / $order->currency_value), 2); @endphp
                                                            @if (DB::table('packages')->where('price', '=', $pprice)->count() > 0)
                                                                <tr>
                                                                    <td colspan="2" class="tfoot-label">
                                                                        {{ DB::table('packages')->where('price', '=', $pprice)->first()->title }}
                                                                    </td>
                                                                    <td class="tfoot-value">
                                                                        {{ \PriceHelper::showOrderCurrencyPrice($order->packing_cost, $order->currency_sign) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif

                                                        {{-- Tax --}}
                                                        @if ($order->tax != 0)
                                                            <tr>
                                                                <td colspan="2" class="tfoot-label">{{ __('Tax') }}
                                                                </td>
                                                                <td class="tfoot-value">
                                                                    {{ \PriceHelper::showOrderCurrencyPrice($order->tax / $order->currency_value, $order->currency_sign) }}
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        {{-- Discount --}}
                                                        @if ($order->coupon_discount != null || ($order->discount ?? 0) > 0)
                                                            <tr class="discount-row">
                                                                <td colspan="2" class="tfoot-label">
                                                                    {{ __('Discount') }}
                                                                    <span class="discount-type-badge">
                                                                        @if ($order->discount_type == 'percent')
                                                                            % Off
                                                                        @elseif ($order->discount_type == 'amount')
                                                                            Fixed
                                                                        @elseif ($order->discount_type == 'loyalty_points')
                                                                            Points
                                                                        @elseif ($order->coupon_discount != null)
                                                                            Coupon
                                                                        @endif
                                                                    </span>
                                                                </td>
                                                                <td class="tfoot-value discount-value">
                                                                    −
                                                                    {{ \PriceHelper::showOrderCurrencyPrice($order->coupon_discount ?? $order->discount, $order->currency_sign) }}
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        {{-- Wallet --}}
                                                        @if ($order->wallet_price != 0)
                                                            <tr>
                                                                <td colspan="2" class="tfoot-label">
                                                                    {{ __('Paid From Wallet') }}</td>
                                                                <td class="tfoot-value">
                                                                    {{ \PriceHelper::showOrderCurrencyPrice($order->wallet_price * $order->currency_value, $order->currency_sign) }}
                                                                </td>
                                                            </tr>
                                                            @if ($order->method != 'Wallet')
                                                                <tr>
                                                                    <td colspan="2" class="tfoot-label">
                                                                        {{ $order->method }}</td>
                                                                    <td class="tfoot-value">
                                                                        {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount * $order->currency_value, $order->currency_sign) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif

                                                        {{-- Grand Total --}}
                                                        <tr class="grand-total-row">
                                                            <td colspan="2" class="tfoot-label grand-total-label">
                                                                {{ __('Grand Total') }}</td>
                                                            <td class="tfoot-value grand-total-value">
                                                                {{ \PriceHelper::showOrderCurrencyPrice(
                                                                    ($order->pay_amount + $order->wallet_price - $order->discount) * $order->currency_value,
                                                                    $order->currency_sign,
                                                                ) }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endsection


                            {{-- Grand Total --}}
                            <tr class="grand-total-row">
                                <td colspan="2" class="tfoot-label grand-total-label">{{ __('Grand Total') }}</td>
                                <td class="tfoot-value grand-total-value">
                                    {{ \PriceHelper::showOrderCurrencyPrice(
                                        ($order->pay_amount + $order->wallet_price - $order->discount) * $order->currency_value,
                                        $order->currency_sign,
                                    ) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
