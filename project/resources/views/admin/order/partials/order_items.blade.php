@php
    $resultArray = [];

    if (!empty($cart['items']) && is_array($cart['items'])) {
        foreach ($cart['items'] as $key => $item) {
            $userId = $item['user_id'] ?? 0;

            if (!isset($resultArray[$userId])) {
                $resultArray[$userId] = [];
            }

            $resultArray[$userId][$key] = $item;
        }
    }

    $grandSubTotal = 0;
@endphp

<div class="row">
    <div class="col-lg-12 order-details-table">
        @forelse ($resultArray as $vendorId => $productt)

            <div class="mr-table mb-4">
                <div class="table-responsive">
                    <table class="table table-hover dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>SKU</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th style="width: 140px;">Qty</th>
                                <th>Discount</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                        <tbody id="order_table">
                            @php
                                $vendorSubTotal = 0;
                            @endphp

                            @foreach ($productt as $cartKey => $product)
                                @php
                                    $itemData = $product['item'] ?? $product;

                                    $productId    = $itemData['id'] ?? explode('_', (string) $cartKey)[0] ?? null;
                                    $productSku   = $itemData['sku'] ?? '';
                                    $productSlug  = $itemData['slug'] ?? null;
                                    $productName  = $itemData['name'] ?? 'Unnamed Product';
                                    $productPhoto = $itemData['photo'] ?? null;

                                    $itemPrice    = (float) ($product['item_price'] ?? ($itemData['price'] ?? 0));
                                    // (int) বাদ দিয়ে (float) করা হয়েছে — decimal qty support
                                    $qty          = (float) ($product['qty'] ?? 0);
                                    $unit         = $product['unit'] ?? 'pc';
                                    $itemDiscount = (float) ($product['discount'] ?? 0);

                                    // gram হলে price kg হিসেবে, তাই qty/1000 করে subtotal
                                    $effectiveQty = $unit === 'gram' ? $qty / 1000 : $qty;
                                    $subtotal     = $itemPrice * $effectiveQty;

                                    $vendorSubTotal += $subtotal;
                                    $grandSubTotal  += $subtotal;

                                    // qty input এর step আর min unit অনুযায়ী
                                    $qtyStep = $unit === 'pc'   ? '1'     : ($unit === 'gram' ? '1' : '0.001');
                                    $qtyMin  = $unit === 'pc'   ? '1'     : ($unit === 'gram' ? '1' : '0.001');
                                @endphp

                                <tr>
                                    <td>{{ $productSku }}</td>

                                    <td>
                                        <img class="img-thumbnail"
                                            src="{{ $productPhoto ? asset('assets/images/products/' . $productPhoto) : asset('assets/images/noimage.png') }}"
                                            alt="No Image"
                                            width="80">
                                    </td>

                                    <td>
                                        @if ($productSlug)
                                            <a target="_blank" href="{{ route('front.product', $productSlug) }}">
                                                {{ mb_strlen($productName, 'utf-8') > 30 ? mb_substr($productName, 0, 30, 'utf-8') . '...' : $productName }}
                                            </a>
                                        @else
                                            {{ mb_strlen($productName, 'utf-8') > 30 ? mb_substr($productName, 0, 30, 'utf-8') . '...' : $productName }}
                                        @endif
                                    </td>

                                    <td>
                                        {{ \PriceHelper::showCurrencyPrice($itemPrice * $order->currency_value, $itemDiscount) }}
                                    </td>

                                    <td>
                                        {{-- unit badge --}}
                                        <span class="badge badge-secondary mb-1">{{ strtoupper($unit) }}</span>
                                        <input type="number"
                                            class="form-control d-inline-block update_qty"
                                            style="width: 90px;"
                                            name="update_qty"
                                            min="{{ $qtyMin }}"
                                            step="{{ $qtyStep }}"
                                            value="{{ $qty }}"
                                            data-cart-key="{{ $cartKey }}"
                                            data-product-id="{{ $productId }}"
                                            data-order-id="{{ $order->id }}"
                                            data-unit="{{ $unit }}">
                                    </td>

                                    <td>
                                        {{ \PriceHelper::showCurrencyPrice($itemDiscount * $order->currency_value) }}
                                    </td>

                                    <td class="row-subtotal-cell">
                                        {{ \PriceHelper::showCurrencyPrice($subtotal * $order->currency_value) }}
                                    </td>

                                    <td>
                                        <button class="btn btn-danger btn-sm remove-item"
                                            data-cart-key="{{ $cartKey }}"
                                            data-product-id="{{ $productId }}"
                                            data-order-id="{{ $order->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                    <td>
                                        {{ $order->created_by ?? 'Customer' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">No product found in this order.</div>
        @endforelse

        @php
            $shipping      = (float) ($order->shipping_cost ?? 0);
            $packing       = (float) ($order->packing_cost ?? 0);
            $tax           = (float) ($order->tax ?? 0);
            $couponDiscount = (float) ($order->coupon_discount ?? 0);
            $orderDiscount = (float) ($order->discount ?? 0);

            $grandTotal = $grandSubTotal + $shipping + $packing + $tax - $couponDiscount - $orderDiscount;
        @endphp

        <div class="row justify-content-md-end mb-3" id="order_totals">
            <div class="col-md-9 col-lg-8">
                <dl class="row text-sm-right">
                    <dt class="col-sm-6">Subtotal</dt>
                    <dd class="col-sm-6 border-bottom">
                        <strong>{{ \PriceHelper::showCurrencyPrice($grandSubTotal * $order->currency_value) }}</strong>
                    </dd>

                    <dt class="col-sm-6">Shipping</dt>
                    <dd class="col-sm-6 border-bottom">
                        <strong>{{ \PriceHelper::showCurrencyPrice($shipping * $order->currency_value) }}</strong>
                    </dd>

                    <dt class="col-sm-6">Packing</dt>
                    <dd class="col-sm-6 border-bottom">
                        <strong>{{ \PriceHelper::showCurrencyPrice($packing * $order->currency_value) }}</strong>
                    </dd>

                    <dt class="col-sm-6">Tax</dt>
                    <dd class="col-sm-6 border-bottom">
                        <strong>{{ \PriceHelper::showCurrencyPrice($tax * $order->currency_value) }}</strong>
                    </dd>

                    <dt class="col-sm-6">Coupon Discount</dt>
                    <dd class="col-sm-6 border-bottom">
                        <strong>- {{ \PriceHelper::showCurrencyPrice($couponDiscount * $order->currency_value) }}</strong>
                    </dd>

                    <dt class="col-sm-6">Order Discount</dt>
                    <dd class="col-sm-6 border-bottom">
                        <strong>- {{ \PriceHelper::showCurrencyPrice($orderDiscount * $order->currency_value) }}</strong>
                    </dd>

                    <dt class="col-sm-6">Total</dt>
                    <dd class="col-sm-6">
                        <strong>{{ \PriceHelper::showCurrencyPrice($grandTotal * $order->currency_value) }}</strong>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>
