<div class="{{ isset($class) ? $class : 'col-md-3 col-lg-2 col-xl-2' }}">

    <div class="single-product">
        <div class="img-wrapper">
            @if ($product->discount > 0)
                @if ($product->discount_type == 'percent')
                    <span class="product-badge">
                        {{ $product->discount }}% OFF
                    </span>
                @elseif($product->discount_type == 'flat')
                    <span class="product-badge">
                        {{ $product->discount }}৳ OFF
                    </span>
                @endif
            @endif


            @if (Auth::check())
                @if (isset($wishlist))
                    <a href="javascript:;" class="removewishlist"
                        data-href="{{ route('user-wishlist-remove', App\Models\Wishlist::where('user_id', '=', $user->id)->where('product_id', '=', $product->id)->first()->id) }}">
                        <div class="add-to-wishlist-btn bg-danger">
                            <i class="fas fa-trash  text-white"></i>
                        </div>
                    </a>
                @else
                    <a href="javascript:;" class="wishlist" data-href="{{ route('user-wishlist-add', $product->id) }}">
                        <div class="add-to-wishlist-btn {{ wishlistCheck($product->id) ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M11.9932 5.13581C9.9938 2.7984 6.65975 2.16964 4.15469 4.31001C1.64964 6.45038 1.29697 10.029 3.2642 12.5604C4.89982 14.6651 9.84977 19.1041 11.4721 20.5408C11.6536 20.7016 11.7444 20.7819 11.8502 20.8135C11.9426 20.8411 12.0437 20.8411 12.1361 20.8135C12.2419 20.7819 12.3327 20.7016 12.5142 20.5408C14.1365 19.1041 19.0865 14.6651 20.7221 12.5604C22.6893 10.029 22.3797 6.42787 19.8316 4.31001C17.2835 2.19216 13.9925 2.7984 11.9932 5.13581Z"
                                    stroke="#030712" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </a>
                @endif
            @endif

            @php
                $cart = Session::has('cart') ? Session::get('cart') : null;
                $existingQty = 0;
                $uniqueKey = null;

                if ($cart && $cart->items) {
                    foreach ($cart->items as $key => $cItem) {
                        if ($cItem['item']->id == $product->id) {
                            $existingQty = $cItem['qty'];
                            $uniqueKey = $cItem['unique_key'];
                            break;
                        }
                    }
                }
            @endphp


            <a href="{{ route('front.product', $product->slug) }}">
                <img class="product-img"
                    src="{{ $product->thumbnail ? asset('assets/images/thumbnails/' . $product->thumbnail) : asset('assets/images/noimage.png') }}"
                    alt="product img">
            </a>
            @if ($product->stock == 0)
                <div class="outofstock-box">
                    <h5>{{ __('Out of Stock !') }}</h5>
                </div>
            @else
                <div>
                    @if ($product->product_type == 'affiliate')
                        @if (false)
                            <!-- Condition Here -->
                            <a href="{{ $product->affiliate_link }}" class="outofstock-box-2">
                                <div class="d-block text-center">

                                    <i class="fa-solid fa-cart-plus"></i>
                                </div>
                                <p class="text-white ">{{ __('Add to Shopping Bag') }}</p>
                            </a>
                        @endif
                    @else
                        @if ($product->type != 'Listing')
                            <div class="cart-ui overlay-ui">
                                @if ($existingQty == 0)
                                    <div class="overlay-add-btn" data-product-id="{{ $product->id }}">
                                        <button type="button" class="outofstock-box-2 add_cart_click"
                                            data-href="{{ route('product.add.to.cart', $product->id) }}"
                                            data-product-id="{{ $product->id }}">
                                            <div class="text-center text-white">
                                                <i class="fa-solid fa-cart-plus"></i>
                                            </div>
                                            <p class="text-white">Add to Shopping Bag</p>
                                        </button>
                                    </div>
                                @else
                                    <div class="outofstock-box-2 qty-plus-wrap qty-wrapper-overlay"
                                        data-product-id="{{ $product->id }}" data-unique-key="{{ $uniqueKey }}">
                                        <button class="btn btn-outline-light border-2 btn-sm qty-minus">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <span class="h3 text-white qty-text">{{ $existingQty }}</span>

                                        <button class="btn btn-outline-light border-2 btn-sm qty-plus">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endif

                </div>
            @endif
        </div>
        <div class="content-wrapper">
            <a href="{{ route('front.product', $product->slug) }}">
                <h6 class="product-title">{{ $product->showName() }}</h6>
            </a>
            <div class="price-wrapper">
                @php
                    $basePrice =
                        $product->discount > 0
                            ? \App\Helpers\PriceHelper::discountPrice(
                                $product->price,
                                $product->discount,
                                $product->discount_type,
                            )
                            : $product->price;
                @endphp

                @if ($product->discount > 0)
                    <h6 class="product-price" data-base-price="{{ $basePrice }}">
                        {{ \App\Helpers\PriceHelper::discountPrice($product->price, $product->discount, $product->discount_type) }}৳
                    </h6>
                    <h6><del>{{ $product->showPrice() }}</del></h6>
                @else
                    <h6 class="product-price" data-base-price="{{ $basePrice }}">{{ $product->showPrice() }}</h6>
                @endif
                <br>

                @if ($product->measure)
                    <h6 class="measure-product">
                        / Per
                        <select class="measure-select" data-measure-type="{{ $product->measure }}">
                            @if ($product->measure == 'KG')
                                <option value="1">1kg</option>
                                <option value="0.5">500gm</option>
                                <option value="0.25">250gm</option>
                            @elseif($product->measure == 'LTR')
                                <option value="1">1L</option>
                                <option value="0.5">500ml</option>
                                <option value="0.25">250ml</option>
                            @elseif($product->measure == 'PCS')
                                <option value="1">1p</option>
                                <option value="5">5p</option>
                                <option value="10">10p</option>
                            @endif
                        </select>
                    </h6>
                @endif
            </div>
            @if ($product->start_date != null && $product->end_date != null)
                <div class="d-flex justify-content-center w-100">
                    <div class="d-flex justify-content-center countdown" data-start="{{ $product->start_date }}"
                        data-end="{{ $product->end_date }}">
                        <span class="flash_timer"></span>
                    </div>
                </div>
            @endif
            {{-- add to cart and cart item quantity increment decrement buttons --}}
            @if ($product->stock !== 0)
                <div class="cart-ui normal-ui w-100">
                    @if ($existingQty == 0)
                        <div class="w-100 d-block mt-auto add-btn-wrapper" data-product-id="{{ $product->id }}">
                            <button
                                class="btn btn-sm add-cart-btn btn-info d-flex d-block w-100 justify-content-center align-items-center add_cart_click"
                                type="button" data-href="{{ route('product.add.to.cart', $product->id) }}"
                                data-product-id="{{ $product->id }}">
                                <i class="fa fa-bolt mr-2"></i> Add To Cart
                            </button>
                        </div>
                    @else
                        <div class="qty-box mt-auto qty-plus-wrap qty-wrapper-normal" data-product-id="{{ $product->id }}"
                            data-unique-key="{{ $uniqueKey }}">
                            <button class="qty-btn qty-minus"><i class="fas fa-minus"></i></button>
                            <span class="qty-text">{{ $existingQty }} in Bag</span>
                            <button class="qty-btn qty-plus"><i class="fas fa-plus"></i></button>
                        </div>
                    @endif
                </div>

            @endif
        </div>
    </div>
</div>
