<!-- Cart Items -->
@if ($cartItems)
    @foreach ($cartItems as $cartItem)
        <div class="cart-item border-bottom">
            <div class="item-qty qty-plus-wrap" data-unique-key="{{ $cartItem['unique_key'] }}" data-product-id="{{ $cartItem['item']['id'] }}">
                <button class="qty-btn qty-plus">
                    <i class="fa-solid fa-chevron-up"></i>
                </button>
                <p>{{ $cartItem['qty'] }}</p>
                <button class="qty-btn qty-minus">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>

            <div class="item-img">
                <img
                    src="{{ $cartItem['item']['photo'] ? asset('assets/images/products/' . $cartItem['item']['photo']) : asset('assets/images/noimage.png') }}">
            </div>

            <div class="item-info">
                <h6>{{ Str::limit($cartItem['item']['name'], 35) }}</h6>
                <p class="item-measure">{{ App\Models\Product::convertPrice($cartItem['item_price']) }} per
                    {{ $cartItem['item']['measure'] }}</p>
            </div>

            <div class="item-price">
                @if ($cartItem['item']['discount'] > 0)
                    <p class="old">{{ $cartItem['item']['discount'] }}</p>
                    <p class="new">{{ $cartItem['item']['price'] * $cartItem['qty'] }}</p>
                @else
                    <p class="new">{{ $cartItem['item']['price'] * $cartItem['qty'] }}</p>
                @endif
            </div>

            <div class="item-remove">
                <a href="javascript:;" class="remove-item-cart" data-key="{{ $cartItem['unique_key'] }}" data-product-id="{{ $cartItem['item']['id'] }}">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>
        </div>
    @endforeach
@endif
