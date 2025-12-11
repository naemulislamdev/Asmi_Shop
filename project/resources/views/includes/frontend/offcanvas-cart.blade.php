<!-- Cart Items -->
@if (count($cartItems) > 0)
    @foreach ($cartItems as $cartItem)
        <div class="cart-item border-bottom">
            <div class="item-qty qty-wrapper" data-unique-key="{{ $cartItem['unique_key'] }}">
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
                    <p class="new">{{ $cartItem['item']['price'] }}</p>
                @else
                    <p class="new">{{ $cartItem['item']['price'] }}</p>
                @endif
            </div>

            <div class="item-remove">
                <a href="javascript:;" class="remove-item-cart" data-key="{{ $cartItem['unique_key'] }}" data-product-id="{{ $cartItem['item']['id'] }}">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            </div>
        </div>
    @endforeach
    @else
        <div class="mt-5 px-2 pt-5 d-flex flex-column justify-content-center align-items-center text-center">
            <img class="ms-3" style="width: 100px"
                        src="{{ asset('assets/front/images/cart.gif') }}" alt="cart icon">
              <h5 style="font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif" class="text-center">Your shopping bag is empty. Start shopping</h5>
        </div>
@endif
