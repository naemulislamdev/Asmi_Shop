<section class="checkout-product">
    <div class="container">
        <nav class="custom-breadcrumb mb-2 mb-lg-0">
            <a href="{{ url('/') }}">Home</a>
            <span class="separator"><i class="fa fa-chevron-right"></i></span>
            <span class="active">Checkout</span>
        </nav>


        <div class="swiper checkout-product-slider">
            <div class="swiper-wrapper sg-product">
                @foreach ($suggestedProducts as $product)
                    @php
                        $cart = session('cart');

                        $isOfferItem = false;

                        if ($cart && $cart->items) {
                            foreach ($cart->items as $cItem) {
                                if ($cItem['item']->id == $product->id) {
                                    $isOfferItem = $cItem['is_offer'] ?? false;
                                }
                            }
                        }
                    @endphp

                    @php
                        $offerMeta = session('offer_meta') ?? [
                            'all_offer_skus' => [],
                            'eligible_offer_skus' => [],
                        ];

                        $hasOfferInCart = session('has_offer_in_cart', false);

                        $isOfferProduct = in_array($product->sku, $offerMeta['all_offer_skus']);
                        $isEligible = in_array($product->sku, $offerMeta['eligible_offer_skus']);
                    @endphp
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
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="{{ $product->photo ? asset('assets/images/products/' . $product->photo) : asset('assets/images/noimage.png') }}"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/noimage.png') }}';"
                                alt="{{ $product->name }}" style="width:100%; height:100%;">
                        </div>
                        <div class="slide-body">
                            <div class="slide-name">{{ $product->name }}</div>

                            @if ($product->stock > 0)
                                <div class="slide-price-group">
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
                                            <h6 class="product-price" data-base-price="{{ $basePrice }}">
                                                {{ $product->showPrice() }}
                                            </h6>
                                        @endif
                                        <br>

                                        @if ($product->measure == 1 && $product->measures->count() > 0)
                                            <h6 class="measure-product">/ Per</h6> <br>
                                            <select class="measure-select" class="form-control">
                                                @foreach ($product->measures as $measure)
                                                    <option value="{{ $measure->value }}"
                                                        data-price="{{ $measure->price }}">
                                                        {{ $measure->label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                                </div>

                                <div class="cart-ui normal-ui w-100">
                                    @if (!$isOfferProduct || ($isOfferProduct && $isEligible && !$hasOfferInCart))
                                        @if ($existingQty == 0)
                                            <div class="w-100 d-block mt-auto add-btn-wrapper"
                                                data-product-id="{{ $product->id }}">
                                                <button
                                                    class="btn btn-sm add-cart-btn btn-info d-flex d-block w-100 justify-content-center align-items-center add_cart_click"
                                                    type="button"
                                                    data-href="{{ route('product.add.to.cart', $product->id) }}"
                                                    data-product-id="{{ $product->id }}">
                                                    <i class="fa fa-bolt me-2"></i> Add To Cart
                                                </button>
                                            </div>
                                        @else
                                            <div class="qty-box mt-auto qty-plus-wrap qty-wrapper-normal"
                                                data-product-id="{{ $product->id }}"
                                                data-unique-key="{{ $uniqueKey }}">
                                                <button class="qty-btn qty-minus"><i class="fas fa-minus"></i></button>
                                                <span class="qty-text">{{ $existingQty }} in Bag</span>
                                                <button class="qty-btn qty-plus"
                                                    {{ $isOfferItem ? 'disabled' : '' }}><i
                                                        class="fas fa-plus"></i></button>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="cps-nav prev" id="cpsPrev" aria-label="Previous">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="cps-nav next" id="cpsNext" aria-label="Next">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
