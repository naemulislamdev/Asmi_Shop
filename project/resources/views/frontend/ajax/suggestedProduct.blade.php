<section class="checkout-product">
    <div class="container">
        <nav class="custom-breadcrumb mb-2 mb-lg-0">
            <a href="{{ url('/') }}">Home</a>
            <span class="separator"><i class="fa fa-chevron-right"></i></span>
            <span class="active">Checkout</span>
        </nav>
        <div class="swiper checkout-product-slider">
            <div class="swiper-wrapper">
                @foreach ($suggestedProducts as $product)
                    <div class="swiper-slide">
                        <div class="slide-img">
                            <img src="{{ $product->photo ? asset('assets/images/products/' . $product->photo) : asset('assets/images/noimage.png') }}"
                                onerror="this.onerror=null; this.src='{{ asset('assets/images/noimage.png') }}';"
                                alt="{{ $product->name }}" style="width:100%; height:100%;">
                        </div>
                        <div class="slide-body">
                            <div class="slide-name">{{ $product->name }}</div>

                            {{-- Price Section --}}
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

                            <div class="slide-price-group">
                                <span class="slide-price-current">{{ number_format($basePrice) }} ৳</span>

                                @if ($product->discount > 0)
                                    <span class="slide-price-original">{{ number_format($product->price) }} ৳</span>
                                    @if ($product->discount_type == 'percent')
                                        <span class="slide-discount-pill">{{ $product->discount }}% ছাড়</span>
                                    @elseif ($product->discount_type == 'flat')
                                        <span class="slide-discount-pill">{{ $product->discount }}৳ ছাড়</span>
                                    @endif
                                @endif

                                @if ($product->measure)
                                    <span class="slide-measure">/
                                        @if ($product->measure == 'KG')
                                            per kg
                                        @elseif ($product->measure == 'LTR')
                                            per ltr
                                        @elseif ($product->measure == 'PCS')
                                            per pcs
                                        @endif
                                    </span>
                                @endif
                            </div>

                            <button class="slide-btn add-to-cart-btn" data-id="{{ $product->id }}">
                                Add to cart
                            </button>
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
