@php
    $resultArray = [];

    if (!empty($cart['items'])) {
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
                                <th>Qty</th>
                                <th>Discount</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                                <th>Created By</th>
                            </tr>
                        </thead>
                        <tbody id="order_table">
                            @php $vendorSubTotal = 0; @endphp

                            @foreach ($productt as $key => $product)
                                @php
                                    $itemPrice = (float) ($product['item_price'] ?? 0);
                                    $qty = (int) ($product['qty'] ?? 0);
                                    $itemDiscount = (float) ($product['discount'] ?? 0);
                                    $subtotal = $itemPrice * $qty;

                                    $vendorSubTotal += $subtotal;
                                    $grandSubTotal += $subtotal;
                                @endphp

                                <tr>
                                    <td>{{ $product['item']['sku'] ?? '' }}</td>
                                    <td>
                                        <img class="img-thumbnail"
                                            src="{{ !empty($product['item']['photo']) ? asset('assets/images/products/' . $product['item']['photo']) : asset('assets/images/noimage.png') }}"
                                            alt="No Image" width="80">
                                    </td>
                                    <td>
                                        <a target="_blank"
                                            href="{{ route('front.product', $product['item']['slug']) }}">
                                            {{ mb_strlen($product['item']['name'], 'utf-8') > 30 ? mb_substr($product['item']['name'], 0, 30, 'utf-8') . '...' : $product['item']['name'] }}
                                        </a>
                                    </td>
                                    <td>{{ \PriceHelper::showCurrencyPrice($itemPrice * $order->currency_value, $itemDiscount) }}
                                    </td>
                                    <td>
                                        <input type="number" class="form-control d-inline-block update_qty"
                                            style="width: 55%;" name="update_qty" min="1"
                                            value="{{ $qty }}" data-product-id="{{ $product['item']['id'] }}"
                                            data-order-id="{{ $order->id }}">
                                    </td>
                                    <td>{{ $itemDiscount }}</td>
                                    <td>{{ $subtotal }}</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm remove-item"
                                            data-product-id="{{ $product['item']['id'] }}"
                                            data-order-id="{{ $order->id }}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                    <td>{{ $order->created_by ?? 'Customer' }}</td>
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
            $shipping = (float) ($order->shipping_cost ?? 0);
            $packing = (float) ($order->packing_cost ?? 0);
            $tax = (float) ($order->tax ?? 0);
            $couponDiscount = (float) ($order->coupon_discount ?? 0);
            $orderDiscount = (float) ($order->discount ?? 0);

            $grandTotal = $grandSubTotal + $shipping + $packing + $tax - $couponDiscount - $orderDiscount;
        @endphp

        <div class="row justify-content-md-end mb-3" id="order_totals">
            <div class="col-md-9 col-lg-8">
                <dl class="row text-sm-right">
                    <dt class="col-sm-6">Subtotal</dt>
                    <dd class="col-sm-6 border-bottom"><strong>{{ $grandSubTotal }}</strong></dd>

                    <dt class="col-sm-6">Shipping</dt>
                    <dd class="col-sm-6 border-bottom"><strong>{{ $shipping }}</strong></dd>

                    <dt class="col-sm-6">Packing</dt>
                    <dd class="col-sm-6 border-bottom"><strong>{{ $packing }}</strong></dd>

                    <dt class="col-sm-6">Tax</dt>
                    <dd class="col-sm-6 border-bottom"><strong>{{ $tax }}</strong></dd>

                    <dt class="col-sm-6">Coupon Discount</dt>
                    <dd class="col-sm-6 border-bottom"><strong>- {{ $couponDiscount }}</strong></dd>

                    <dt class="col-sm-6">Order Discount</dt>
                    <dd class="col-sm-6 border-bottom"><strong>- {{ $orderDiscount }}</strong></dd>

                    <dt class="col-sm-6">Total</dt>
                    <dd class="col-sm-6"><strong>{{ $grandTotal }}</strong></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
