@extends('layouts.front')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap');

    .order-success-wrapper {
        background: #f9fafb;
        font-family: "Rubik", sans-serif;
    }

    .shipping-cost {
        font-family: "Rubik";
    }

    .order-success-wrapper {
        background: #f9fafb;
    }

    .success-card {
        background: #fff;
        border-radius: 6px;
        padding: 20px 40px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    }

    /* HEADER */
    .success-header {
        text-align: center;
    }

    .success-icon {
        width: 120px;
    }

    .success-header h2 {
        color: #2ecc71;
        margin-top: 15px;
    }

    .btn-home {
        display: inline-block;
        background: linear-gradient(45deg, #1598a7, #1bb9cb);
        color: #fff;
        padding: 12px 30px;
        border-radius: 50px;
    }

    /* ORDER INFO */
    .order-info {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin: 40px 0;
    }

    .info-box {
        background: #f5f7fa;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
    }

    /* LOYALTY */
    .loyalty-box {
        /* margin-top: 20px; */
        text-align: center;
        padding: 30px;
        /* background: linear-gradient(135deg, #fff3cd, #ffe0b2); */
        /* background: #444444; */
        border-radius: 16px;
        /* color: #FFF !important; */
    }

    .points {
        font-size: 50px;
        font-weight: bold;
        color: #ff6a00;
    }

    .total-points {
        margin-top: 10px;
        font-weight: 600;
        font-size: 24px;
    }


    /* ADDRESS */
    .address-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-top: 40px;
    }

    .address-card {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 12px;
    }

    /* PRODUCTS */
    .product-section {
        margin-top: 40px;
    }

    .product-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f9fafb;
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .product-item img {
        width: 60px;
        border-radius: 8px;
    }

    .product-info {
        flex: 1;
        margin-left: 15px;
    }





    .order-info .info-box h6 {
        font-size: 20px;
    }

    .order-info .info-box p {
        font-size: 17px;
    }

    .giftBox img {
        width: 150px;
        margin-top: 15px;
    }

    .order-summary {
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        background: #fff;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 13px 20px;
        border-bottom: 0.5px solid #f0f1f3;
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-key {
        font-size: 15px;
        color: #111827;
    }

    .summary-val {
        font-size: 14px;
        font-weight: 500;
        color: #111827;
        text-align: right;
        font-family: "Rubik", sans-serif;
    }

    /* Discount row */
    .discount-val {
        color: #d97706;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .discount-badge {
        font-size: 11px;
        font-weight: 500;
        background: #fff8f0;
        color: #b05f10;
        border: 0.5px solid #f5d7b0;
        padding: 2px 8px;
        border-radius: 20px;
    }

    /* Payment method badge */
    .method-badge {
        font-size: 12px;
        font-weight: 500;
        background: #f0fdf4;
        color: #15803d;
        border: 0.5px solid #bbf7d0;
        padding: 3px 10px;
        border-radius: 20px;
    }

    /* Grand total row */
    .grand-total-row {
        background: #f9fafb;
    }

    .grand-total-val {
        font-size: 16px;
        color: #15803d;
    }

    .free-val {
        color: #15803d;
        font-weight: 500;
    }

    /* payment mehtod and customer info */
    .address-section {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-top: 24px;
    }

    .address-card {
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }

    .address-card-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        background: #f9fafb;
        border-bottom: 0.5px solid #e5e7eb;
    }

    .address-card-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #e8f6f8;
        color: #1598a7;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .address-card-header h6 {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin: 0;
    }

    .address-card-body {
        padding: 4px 0;
    }

    .address-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 16px;
        border-bottom: 0.5px solid #f3f4f6;
    }

    .address-row:last-child {
        border-bottom: none;
    }

    .address-key {
        font-size: 13px;
        color: #6b7280;
        flex-shrink: 0;
    }

    .address-val {
        font-size: 13px;
        font-weight: 500;
        color: #111827;
        text-align: right;
        margin-left: 12px;
    }

    .txn-val {
        font-family: monospace;
        font-size: 12px;
        color: #6b7280;
    }

    .info-badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .badge-green {
        background: #e9faf3;
        color: #15803d;
        border: 0.5px solid #bbf7d0;
    }

    .badge-amber {
        background: #fff8f0;
        color: #b05f10;
        border: 0.5px solid #fcd34d;
        font-family: "Rubik", sans-serif;
    }

    @media (max-width: 576px) {
        .address-section {
            grid-template-columns: 1fr;
        }
    }

    /* Product list */
    .product-section {
        margin-top: 24px;
        border: 0.5px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }

    .product-section-header {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        background: #f9fafb;
        border-bottom: 0.5px solid #e5e7eb;
    }

    .product-section-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #e8f6f8;
        color: #1598a7;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .product-section-header h6 {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
        margin: 0;
        flex: 1;
    }

    .product-count {
        font-size: 11px;
        font-weight: 600;
        background: #e8f6f8;
        color: #1598a7;
        border: 0.5px solid #b2e8f0;
        padding: 3px 10px;
        border-radius: 20px;
    }

    .product-list {
        padding: 4px 0;
    }

    .product-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-bottom: 0.5px solid #f3f4f6;
        transition: background 0.15s;
    }

    .product-item:last-child {
        border-bottom: none;
    }

    .product-item:hover {
        background: #fafafa;
    }

    .product-item img {
        width: 52px;
        height: 52px;
        border-radius: 8px;
        object-fit: cover;
        border: 0.5px solid #e5e7eb;
        flex-shrink: 0;
    }

    .product-info {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .product-info h6 {
        font-size: 14px;
        font-weight: 500;
        color: #111827;
        margin: 0;
        line-height: 1.4;
    }

    .product-qty {
        font-size: 12px;
        color: #6b7280;
    }

    .product-price {
        font-size: 14px;
        font-weight: 600;
        color: #111827;
        flex-shrink: 0;
        font-family: "Rubik";
    }

    @media (max-width: 768px) {
        .order-info {
            grid-template-columns: repeat(2, 1fr);
        }

        .address-section {
            grid-template-columns: 1fr;
        }

        .success-card {
            padding: 20px 12px;

        }
    }
</style>
@section('content')
    <div class="order-success-wrapper">
        <div class="container">

            <div class="success-card">

                <!-- ✅ SUCCESS HEADER -->
                <div class="success-header">
                    <img src="{{ asset('assets/front/images/success-check.gif') }}" class="success-icon">

                    <h2>Order Placed Successfully 🎉</h2>
                    <p>Thank you! Your order has been confirmed.</p>

                    <a href="{{ route('front.index') }}" class="btn-home">
                        Continue Shopping
                    </a>
                </div>


                <!-- ✅ LOYALTY SECTION -->
                <div class="loyalty-box ">
                    @if ($order->loyalty_point > 0)
                        <h4>🎁 You Earned Rewards</h4>

                        <div class="points">
                            <span id="loyaltyCounter">{{ $order->loyalty_point }}</span>
                        </div>
                        <div class="giftBox">
                            <img src="{{ asset('assets/front/images/download.gif') }}" alt="Reward Point Open Box">
                        </div>

                        <p class="points-text">
                            Loyalty Points Earned
                        </p>

                        <div class="total-points text-success">
                            Total Balance: {{ auth()->user() ? auth()->user()->wallet_points : 0 }}
                        </div>
                        <p><i>N.B: Minimum 100 reward point is required to withdraw.</i></p>
                    @else
                        <div class="total-points text-success">
                            Total Balance: {{ auth()->user() ? auth()->user()->wallet_points : 0 }}
                        </div>
                    @endif
                </div>
                <!-- ORDER SUMMARY -->
                <!-- ORDER SUMMARY -->
                <div class="order-summary mt-3">
                    <div class="summary-row">
                        <span class="summary-key">Order Number</span>
                        <span class="summary-val">#{{ $order->order_number }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-key">Order Date</span>
                        <span class="summary-val">{{ date('d F Y, h:i A', strtotime($order->created_at)) }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-key">Subtotal</span>
                        <span class="summary-val">
                            @php $total = $order->pay_amount * $order->currency_value + ($order->discount ?? 0); @endphp
                            {{ \PriceHelper::showOrderCurrencyPrice($total, $order->currency_sign) }}
                        </span>
                    </div>

                    @if (($order->discount ?? 0) > 0)
                        <div class="summary-row">
                            <span class="summary-key">Discount</span>
                            <span class="summary-val discount-val">
                                − {{ \PriceHelper::showOrderCurrencyPrice($order->discount, $order->currency_sign) }}
                                <span class="discount-badge">
                                    @if ($order->discount_type == 'percent')
                                        % Off
                                    @elseif ($order->discount_type == 'amount')
                                        Fixed
                                    @elseif ($order->discount_type == 'loyalty_points')
                                        Points
                                    @endif
                                </span>
                            </span>
                        </div>
                    @endif

                    {{-- ✅ Delivery Charge --}}
                    <div class="summary-row">
                        <span class="summary-key">Delivery Charge</span>
                        <span class="summary-val {{ $order->shipping_cost <= 0 ? 'free-val' : '' }}">
                            @if ($order->shipping_cost <= 0)
                                Free
                            @else
                                {{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost * $order->currency_value, $order->currency_sign) }}
                            @endif
                        </span>
                    </div>

                    <div class="summary-row">
                        <span class="summary-key">Payment Method</span>
                        <span class="summary-val">
                            <span class="method-badge">{{ $order->method }}</span>
                        </span>
                    </div>

                    <div class="summary-row grand-total-row">
                        <span class="summary-key"><strong>Grand Total</strong></span>
                        <span class="summary-val grand-total-val fw-bold">
                            @php
                                $grandTotal =
                                    $order->pay_amount * $order->currency_value +
                                    ($order->shipping_cost > 0 ? $order->shipping_cost * $order->currency_value : 0);
                            @endphp
                            {{ \PriceHelper::showOrderCurrencyPrice($grandTotal, $order->currency_sign) }}
                        </span>
                    </div>
                </div>

                <!-- ✅ ADDRESS -->
                <div class="address-section">

                    {{-- Shipping Info --}}
                    <div class="address-card">
                        <div class="address-card-header">
                            <div class="address-card-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="12" cy="9" r="2.5" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </div>
                            <h6>Shipping Info</h6>
                        </div>
                        <div class="address-card-body">
                            <div class="address-row">
                                <span class="address-key">Name</span>
                                <span class="address-val">{{ $order->customer_name }}</span>
                            </div>
                            <div class="address-row">
                                <span class="address-key">Address</span>
                                <span class="address-val">{{ $order->customer_address }}</span>
                            </div>
                            <div class="address-row">
                                <span class="address-key">Phone</span>
                                <span class="address-val">{{ $order->customer_phone }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Info --}}
                    <div class="address-card">
                        <div class="address-card-header">
                            <div class="address-card-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="5" width="20" height="14" rx="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <path d="M2 10h20" stroke="currentColor" stroke-width="1.5" />
                                </svg>
                            </div>
                            <h6>Payment Info</h6>
                        </div>
                        <div class="address-card-body">
                            <div class="address-row">
                                <span class="address-key">Method</span>
                                <span class="address-val">
                                    <span class="info-badge badge-green">{{ $order->method }}</span>
                                </span>
                            </div>
                            <div class="address-row">
                                <span class="address-key">Delivery Charge</span>
                                <span class="address-val">
                                    @if ($order->shipping_cost <= 0)
                                        <span class="info-badge badge-green">Free</span>
                                    @else
                                        <span
                                            class="info-badge badge-amber">{{ \PriceHelper::showOrderCurrencyPrice($order->shipping_cost, $order->currency_sign) }}</span>
                                    @endif
                                </span>
                            </div>
                            <div class="address-row">
                                <span class="address-key">Transaction</span>
                                <span class="address-val txn-val">{{ $order->txnid ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ✅ PRODUCT LIST -->
                <div class="product-section">
                    <div class="product-section-header">
                        <div class="product-section-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" stroke="currentColor"
                                    stroke-width="1.5" stroke-linejoin="round" />
                                <path d="M3 6h18M16 10a4 4 0 01-8 0" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                        </div>
                        <h6>Ordered Products</h6>
                        <span class="product-count">{{ count($tempcart->items) }} items</span>
                    </div>

                    <div class="product-list">
                        @foreach ($tempcart->items as $product)
                            <div class="product-item">
                                <img src="{{ asset('assets/images/products/' . $product['item']['photo']) }}"
                                    alt="{{ $product['item']['name'] }}"
                                    onerror="this.src='{{ asset('assets/front/images/placeholder.png') }}'">

                                <div class="product-info">
                                    <h6>{{ $product['item']['name'] }}</h6>
                                    <span class="product-qty">Qty: {{ $product['qty'] }}</span>
                                </div>

                                <div class="product-price">
                                    {{ \PriceHelper::showCurrencyPrice($product['price'] * $order->currency_value) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let target = {{ $order->loyalty_point ?? 0 }};
        let count = 0;
        let el = document.getElementById("loyaltyCounter");
        let speed = Math.ceil(target / 40);
        let interval = setInterval(() => {
                count += speed;
                if (count >= target) {
                    count = target;
                    clearInterval(interval);
                }
                el.innerText = count;
            },
            30);
        setTimeout(() => {

            confetti({
                particleCount: 400,
                spread: 120,
                origin: {
                    y: 0.3,
                    x: 0.6
                }
            });
        }, 0);
    });
</script>
