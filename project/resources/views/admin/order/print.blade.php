<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice — {{ $order->order_number }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/' . $gs->favicon) }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #1f2937;
            background: #fff;
            padding: 40px;
        }

        /* ── Header ── */
        .inv-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 2px solid #1598a7;
            margin-bottom: 28px;
        }

        .inv-header img {
            max-height: 52px;
            object-fit: contain;
        }

        .inv-label {
            text-align: right;
        }

        .inv-label h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1598a7;
            letter-spacing: -0.5px;
        }

        .inv-label p {
            font-size: 12px;
            color: #6b7280;
            margin-top: 4px;
        }

        /* ── Meta Grid ── */
        .inv-meta {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 28px;
        }

        .inv-meta-box {
            background: #f9fafb;
            border: 0.5px solid #e5e7eb;
            border-radius: 10px;
            padding: 14px 16px;
        }

        .inv-meta-box h6 {
            font-size: 10px;
            font-weight: 600;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin-bottom: 10px;
        }

        .inv-meta-box p {
            font-size: 12px;
            color: #374151;
            line-height: 1.8;
        }

        .inv-meta-box p strong {
            color: #111827;
            font-weight: 600;
        }

        /* ── Table ── */
        .inv-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .inv-table thead tr {
            background: #1598a7;
        }

        .inv-table thead th {
            padding: 10px 14px;
            font-size: 11px;
            font-weight: 600;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: left;
        }

        .inv-table thead th:last-child {
            text-align: right;
        }

        .inv-table tbody tr {
            border-bottom: 0.5px solid #f0f1f3;
        }

        .inv-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .inv-table tbody td {
            padding: 12px 14px;
            color: #374151;
            vertical-align: top;
            font-size: 12px;
        }

        .inv-table tbody td:last-child {
            text-align: right;
            font-weight: 600;
        }

        .product-name {
            font-weight: 600;
            color: #111827;
            font-size: 13px;
        }

        .detail-row {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-top: 4px;
            font-size: 12px;
            color: #6b7280;
        }

        .detail-row strong {
            color: #374151;
            font-weight: 500;
        }

        .color-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            border: 1px solid rgba(0, 0, 0, 0.15);
        }

        .off-badge {
            font-size: 10px;
            font-weight: 600;
            background: #fff8f0;
            color: #b05f10;
            border: 0.5px solid #fcd34d;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 6px;
        }

        /* ── Tfoot Summary ── */
        .inv-summary {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .inv-summary td {
            padding: 8px 14px;
            font-size: 12px;
            border-top: 0.5px solid #f0f1f3;
        }

        .sum-label {
            color: #6b7280;
            text-align: right;
            width: 70%;
        }

        .sum-value {
            color: #111827;
            font-weight: 600;
            text-align: right;
            white-space: nowrap;
        }

        .sum-discount .sum-label,
        .sum-discount .sum-value {
            color: #d97706;
        }

        .badge-free {
            font-size: 10px;
            font-weight: 600;
            background: #e9faf3;
            color: #15803d;
            border: 0.5px solid #bbf7d0;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .discount-type-badge {
            font-size: 10px;
            font-weight: 600;
            background: #fff8f0;
            color: #b05f10;
            border: 0.5px solid #fcd34d;
            padding: 2px 6px;
            border-radius: 10px;
            margin-left: 4px;
        }

        .grand-total-row td {
            background: #f0fbfc;
            border-top: 2px solid #1598a7 !important;
            padding-top: 12px !important;
            padding-bottom: 12px !important;
        }

        .grand-total-row .sum-label {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }

        .grand-total-row .sum-value {
            font-size: 16px;
            font-weight: 700;
            color: #15803d;
        }

        /* ── Footer ── */
        .inv-footer {
            margin-top: 40px;
            padding-top: 16px;
            border-top: 0.5px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .inv-footer p {
            font-size: 11px;
            color: #9ca3af;
        }

        .inv-footer .thank-you {
            font-size: 13px;
            font-weight: 600;
            color: #1598a7;
        }

        /* ── Print ── */
        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            body {
                padding: 28px 36px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            ::-webkit-scrollbar {
                width: 0;
                background: transparent;
            }
        }
    </style>
</head>

<body onload="window.print();">

    {{-- Header --}}
    <div class="inv-header">
        <img src="{{ asset('assets/images/' . $gs->invoice_logo) }}" alt="Logo">
        <div class="inv-label">
            <h1>INVOICE</h1>
            <p>#{{ sprintf("%'.08d", $order->id) }}</p>
            <p>{{ date('d M Y, h:i A', strtotime($order->created_at)) }}</p>
        </div>
    </div>

    {{-- Meta Info --}}
    <div class="inv-meta">

        <div class="inv-meta-box">
            <h6>{{ __('Order Details') }}</h6>
            <p>
                <strong>{{ __('Invoice No') }}:</strong> {{ sprintf("%'.08d", $order->id) }}<br>
                <strong>{{ __('Order ID') }}:</strong> {{ $order->order_number }}<br>
                <strong>{{ __('Date') }}:</strong> {{ date('d M Y, h:i A', strtotime($order->created_at)) }}<br>
                @if ($order->dp == 0)
                    <strong>{{ __('Shipping') }}:</strong> {{ $order->shippingMethod->title ?? 'N/A' }}<br>
                @endif
                <strong>{{ __('Payment') }}:</strong> {{ $order->method }}
            </p>
        </div>

        @if ($order->dp == 0)
            <div class="inv-meta-box">
                <h6>{{ __('Shipping Details') }}</h6>
                <p>
                    <strong>{{ __('Name') }}:</strong> {{ $order->shipping_name ?? $order->customer_name }}<br>
                    <strong>{{ __('Address') }}:</strong>
                    {{ $order->shipping_address ?? $order->customer_address }}<br>
                    <strong>{{ __('Phone') }}:</strong> {{ $order->customer_phone ?? 'N/A' }}<br>
                    @if ($order->order_note)
                        <strong>{{ __('Note') }}:</strong> {{ $order->order_note }}
                    @endif
                </p>
            </div>
        @endif

        <div class="inv-meta-box">
            <h6>{{ __('Billing Details') }}</h6>
            <p>
                <strong>{{ __('Branch') }}:</strong> {{ $order->branch->name ?? 'N/A' }}<br>
                <strong>{{ __('Address') }}:</strong> {{ $order->branch->address ?? 'N/A' }}
            </p>
        </div>

    </div>

    {{-- Products Table --}}
    @php $subtotal = 0; @endphp

    <table class="inv-table">
        <thead>
            <tr>
                <th style="width:35%">{{ __('Product') }}</th>
                <th>{{ __('Details') }}</th>
                <th>{{ __('Total') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart['items'] as $product)
                <tr>
                    <td>
                        <div class="product-name">{{ $product['item']['name'] }}</div>
                    </td>
                    <td>
                        @if ($product['size'])
                            <div class="detail-row">
                                <strong>{{ __('Size') }}:</strong>
                                {{ str_replace('-', ' ', $product['size']) }}
                            </div>
                        @endif
                        @if ($product['color'])
                            <div class="detail-row">
                                <strong>{{ __('Color') }}:</strong>
                                <span class="color-dot" style="background:#{{ $product['color'] }};"></span>
                            </div>
                        @endif
                        <div class="detail-row">
                            <strong>{{ __('Price') }}:</strong>
                            {{ \PriceHelper::showCurrencyPrice($product['item_price'] * $order->currency_value) }}
                        </div>
                        <div class="detail-row">
                            <strong>{{ __('Qty') }}:</strong>
                            {{ $product['qty'] }} {{ $product['item']['measure'] ?? '' }}
                        </div>
                        @if (!empty($product['keys']))
                            @foreach (array_combine(explode(',', $product['keys']), explode(',', $product['values'])) as $key => $value)
                                <div class="detail-row">
                                    <strong>{{ ucwords(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                                </div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        {{ \PriceHelper::showCurrencyPrice($product['price'] * $order->currency_value) }}
                        @if ($product['discount'] != 0)
                            <span class="off-badge">{{ $product['discount'] }}% Off</span>
                        @endif
                    </td>
                </tr>
                @php
                    $subtotal += round(($product['price'] / $order->currency_value) * $order->currency_value, 2);
                @endphp
            @endforeach
        </tbody>
    </table>

    {{-- Summary --}}
    <table class="inv-summary">

        <tr>
            <td class="sum-label">{{ __('Subtotal') }}</td>
            <td class="sum-value">
                {{ \PriceHelper::showOrderCurrencyPrice($subtotal * $order->currency_value, $order->currency_sign) }}
            </td>
        </tr>

        {{-- Delivery --}}
        @if ($order->shipping_cost != 0)
            @php $price = round(($order->shipping_cost / $order->currency_value), 2); @endphp
            @if (DB::table('shippings')->where('price', '=', $price)->count() > 0)
                <tr>
                    <td class="sum-label">
                        Delivery Charge
                        <small>({{ DB::table('shippings')->where('price', '=', $price)->first()->title }})</small>
                    </td>
                    <td class="sum-value">
                        {{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost, $order->currency_sign) }}
                    </td>
                </tr>
            @endif
        @else
            <tr>
                <td class="sum-label">{{ __('Delivery Charge') }}</td>
                <td class="sum-value"><span class="badge-free">Free</span></td>
            </tr>
        @endif

        {{-- Packing --}}
        @if ($order->packing_cost != 0)
            @php $pprice = round(($order->packing_cost / $order->currency_value), 2); @endphp
            @if (DB::table('packages')->where('price', '=', $pprice)->count() > 0)
                <tr>
                    <td class="sum-label">
                        {{ DB::table('packages')->where('price', '=', $pprice)->first()->title }}
                    </td>
                    <td class="sum-value">
                        {{ \PriceHelper::showOrderCurrencyPrice($order->packing_cost, $order->currency_sign) }}
                    </td>
                </tr>
            @endif
        @endif

        {{-- Tax --}}
        @if ($order->tax != 0)
            <tr>
                <td class="sum-label">{{ __('Tax') }}</td>
                <td class="sum-value">
                    {{ \PriceHelper::showOrderCurrencyPrice($order->tax / $order->currency_value, $order->currency_sign) }}
                </td>
            </tr>
        @endif

        {{-- Discount --}}
        @if ($order->coupon_discount != null || ($order->discount ?? 0) > 0)
            <tr class="sum-discount">
                <td class="sum-label">
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
                <td class="sum-value">
                    −
                    {{ \PriceHelper::showOrderCurrencyPrice($order->coupon_discount ?? $order->discount, $order->currency_sign) }}
                </td>
            </tr>
        @endif

        {{-- Wallet --}}
        @if ($order->wallet_price != 0)
            <tr>
                <td class="sum-label">{{ __('Paid From Wallet') }}</td>
                <td class="sum-value">
                    {{ \PriceHelper::showOrderCurrencyPrice($order->wallet_price * $order->currency_value, $order->currency_sign) }}
                </td>
            </tr>
            @if ($order->method != 'Wallet')
                <tr>
                    <td class="sum-label">{{ $order->method }}</td>
                    <td class="sum-value">
                        {{ \PriceHelper::showOrderCurrencyPrice($order->pay_amount * $order->currency_value, $order->currency_sign) }}
                    </td>
                </tr>
            @endif
        @endif

        {{-- Grand Total --}}
        <tr class="grand-total-row">
            <td class="sum-label">{{ __('Grand Total') }}</td>
            <td class="sum-value">
                {{ \PriceHelper::showOrderCurrencyPrice(
                    ($order->pay_amount + $order->wallet_price - $order->discount) * $order->currency_value,
                    $order->currency_sign,
                ) }}
            </td>
        </tr>

    </table>

    {{-- Footer --}}
    <div class="inv-footer">
        <p>{{ $gs->title ?? '' }}</p>
        <p class="thank-you">Thank you for your order!</p>
        <p>{{ date('d M Y, h:i A', strtotime($order->created_at)) }}</p>
    </div>

</body>

</html>
