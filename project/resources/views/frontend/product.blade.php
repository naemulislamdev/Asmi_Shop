@extends('layouts.front')
@section('css')
    <style>
        :root {
            --primary: #1a6b4a;
            --primary-light: #e8f5ee;
            --primary-mid: #2d9b6e;
            --accent: #e63946;
            --accent-light: #fff0f1;
            --gold: #c8860a;
            --gold-light: #fef8ec;
            --bg: #f7f7f5;
            --surface: #ffffff;
            --surface2: #f2f1ef;
            --text: #1a1a1a;
            --text2: #555;
            --text3: #888;
            --border: #e0dedd;
            --radius: 14px;
            --radius-sm: 8px;
            --shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
            --shadow-hover: 0 6px 28px rgba(0, 0, 0, 0.12);
        }

        /* ==================================
                                                                                                                                                                                                        Breadcumb style start
                                                                                                                                                                                                    =====================================*/

        .custom-breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            font-size: 14px;
            background: #fff;
            padding: 10px 15px;
            border-radius: 8px;
        }

        /* links */
        .custom-breadcrumb a {
            color: #007bff;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;

        }

        .custom-breadcrumb span {
            font-size: 0.9rem;
        }

        .custom-breadcrumb a:hover {
            color: #007bff;
        }

        /* separator icon */
        .custom-breadcrumb .separator {
            margin: 0 8px;
            color: #adb5bd;
            font-size: 12px;
        }

        /* active item */
        .custom-breadcrumb .active {
            color: #212529;
            font-weight: 600;
        }

        /* optional: spacing fix for mobile */
        @media (max-width: 576px) {
            .custom-breadcrumb {
                font-size: 13px;
                padding: 8px 10px;
            }
        }

        /* ==================================
                                                                                                                                                                                                                    Breadcumb style End
                                                                                                                                                                                                    =====================================*/

        .single-product-details-content-wrapper .qty-box,
        .single-product-details-content-wrapper .add-btn-wrapper {
            width: 40%;
        }

        .add-cart-btn.btn-info {
            width: 50% !important;
        }

        .single-product-details-content-wrapper .gs-product-details-gallery-wrapper .main-img {
            -o-object-fit: contain;
            object-fit: contain;
            cursor: zoom-in;
        }

        /* ==================================
                                                                                                                                                                                                                    Promo Offer style start
                                                                                                                                                                                                     =====================================*/

        .promoOfferWrap {
            padding: 10px 0 4px;
        }

        .promoOfferLabel {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.07em;
            color: #888;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .promoOfferList {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .promoOfferCard {
            display: flex;
            align-items: stretch;
            border-radius: 10px;
            border: 0.5px solid #ddd;
            overflow: hidden;
            background: #fff;
            transition: border-color 0.15s, transform 0.12s;
            cursor: default;
        }

        .promoOfferCard:hover {
            border-color: #aaa;
            transform: translateY(-1px);
        }

        .promoOfferAccent {
            width: 5px;
            flex-shrink: 0;
        }

        .promoOfferBody {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
        }

        .promoOfferIcon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .promoOfferText {
            flex: 1;
        }

        .promoOfferThreshold {
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .promoOfferDesc {
            font-size: 13px;
            color: #222;
            font-weight: 400;
        }

        .promoOfferBadge {
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 20px;
            flex-shrink: 0;
            white-space: nowrap;
            border: 0.5px solid transparent;
            font-family: "Rubik", sans-serif;
        }

        /* Green */
        .promoOfferCard--green .promoOfferAccent {
            background: #1D9E75;
        }

        .promoOfferCard--green .promoOfferIcon {
            background: #E1F5EE;
        }

        .promoOfferCard--green .promoOfferThreshold {
            color: #085041;
        }

        .promoOfferCard--green .promoOfferBadge {
            background: #E1F5EE;
            color: #085041;
            border-color: #9FE1CB;
        }

        /* Amber */
        .promoOfferCard--amber .promoOfferAccent {
            background: #BA7517;
        }

        .promoOfferCard--amber .promoOfferIcon {
            background: #FAEEDA;
        }

        .promoOfferCard--amber .promoOfferThreshold {
            color: #633806;
        }

        .promoOfferCard--amber .promoOfferBadge {
            background: #FAEEDA;
            color: #633806;
            border-color: #FAC775;
        }

        /* Blue */
        .promoOfferCard--blue .promoOfferAccent {
            background: #378ADD;
        }

        .promoOfferCard--blue .promoOfferIcon {
            background: #E6F1FB;
        }

        .promoOfferCard--blue .promoOfferThreshold {
            color: #0C447C;
        }

        .promoOfferCard--blue .promoOfferBadge {
            background: #E6F1FB;
            color: #0C447C;
            border-color: #85B7EB;
        }

        /* Coral */
        .promoOfferCard--coral .promoOfferAccent {
            background: #D85A30;
        }

        .promoOfferCard--coral .promoOfferIcon {
            background: #FAECE7;
        }

        .promoOfferCard--coral .promoOfferThreshold {
            color: #712B13;
        }

        .promoOfferCard--coral .promoOfferBadge {
            background: #FAECE7;
            color: #712B13;
            border-color: #F0997B;
        }

        /* Pink */
        .promoOfferCard--pink .promoOfferAccent {
            background: #D4537E;
        }

        .promoOfferCard--pink .promoOfferIcon {
            background: #FBEAF0;
        }

        .promoOfferCard--pink .promoOfferThreshold {
            color: #72243E;
        }

        .promoOfferCard--pink .promoOfferBadge {
            background: #FBEAF0;
            color: #72243E;
            border-color: #ED93B1;
        }

        /* ==================================
                                                                                                                                                                                                    Promo Offer style End
                                                                                                                                                                                                =====================================*/


        .discount-pill {
            background: var(--primary-light);
            color: var(--primary);
            font-size: 12px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 50px;
            border: 1px solid var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .original-price {
            font-size: 1.1rem;
            color: var(--text3) !important;
            text-decoration: line-through;
        }

        .current-price {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary) !important;
            letter-spacing: -1px;
        }

        .single-product-details-content-wrapper .product-info-wrapper .price-wrapper {
            display: flex;
            gap: 8px;
            align-items: center !important;
        }

        /* ========================================
                                                                                                                                                                        Flash Deal timer style Start
                                                                                                                                                                    ========================================== */
        .product-countdown {
            margin-top: 30px;
            background: #E1F5EE;
            border: 0.5px solid #9FE1CB;
            border-radius: 8px;
            display: inline-flex;
            flex-direction: column
        }

        .flash-sale-badge {
            color: #085041;
            border-radius: 8px;
            padding: 3px 10px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
        }

        .flash-block {
            background: #fff;
            border: 0.5px solid #9FE1CB;
            border-radius: 5px;
            padding: 3px 7px;
            min-width: 34px;
        }

        .flash-num {
            font-size: 15px;
            font-weight: 700;
            color: #085041;
            font-variant-numeric: tabular-nums;
        }

        .flash-label {
            font-size: 8px;
            color: #1D9E75;
            margin-top: 1px;
        }

        .flash-sep {
            font-size: 13px;
            font-weight: 700;
            color: #1D9E75;
            padding-bottom: 6px;
        }

        .flash-timer-wrap {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #E1F5EE;

            border-radius: 8px;
            padding: 5px 10px;
        }

        /* ========================================
                                                                                                                                                                                                        Flash Deal timer style End
                                                                                                                                                                                                    ========================================== */
        /* stock and sku section */
        .product-meta-flex {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 16px;
            padding: 12px 0;
            /* অথবা যতটুকু দরকার */
        }

        .product-meta-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
            min-width: 100px;
        }

        .meta-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #888;
        }

        .meta-value {
            font-size: 13px;
            color: #222;
            font-weight: 500;
        }

        .product-meta-item span {
            display: inline-block !important;
            padding: 5px 0 !important;
        }

        /* description, review tab style start */
        /* Tab nav */
        .tab-product-des-wrapper .nav-tabs {
            border-bottom: 0.5px solid #e0e0e0;
            background: #f9f9f9;
            padding: 0 20px;
            gap: 4px;
            flex-wrap: nowrap;
            overflow-x: auto;
        }

        .tab-product-des-wrapper .nav-tabs .nav-link {
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #666;
            border: none;
            border-bottom: 2px solid transparent;
            border-radius: 0;
            background: none;
            white-space: nowrap;
            transition: color .15s, border-color .15s;
        }

        .tab-product-des-wrapper .nav-tabs .nav-link:hover {
            color: #222;
        }

        .tab-product-des-wrapper .nav-tabs .nav-link.active {
            color: #0F6E56;
            border-bottom-color: #1D9E75;
            font-weight: 600;
            background: none;
        }

        /* Tab content wrapper */
        .tab-product-des-wrapper .tab-content {
            padding: 24px;
            background: #fff;
            border: 0.5px solid #e0e0e0;
            border-top: none;
            border-radius: 0 0 12px 12px;
        }

        /* Review cards */
        .single-comment {
            display: flex;
            gap: 12px;
            padding: 14px;
            border: 0.5px solid #e8e8e8;
            border-radius: 10px;
            background: #fafafa;
            margin-bottom: 10px;
        }

        .single-comment .left-area {
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 60px;
            text-align: center;
        }

        .single-comment .left-area img {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 6px;
        }

        .single-comment .left-area .name {
            font-size: 12px;
            font-weight: 600;
            color: #222;
        }

        /* Wholesell table */
        .price-summary {
            border: 0.5px solid #e0e0e0;
            border-radius: 10px;
            overflow: hidden;
        }

        .price-summary-list {
            list-style: none;
            padding: 0;
        }

        .price-summary-list .regular-price {
            display: flex;
            justify-content: space-between;
            padding: 8px 16px;
            background: #f5f5f5;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: #888;
            border-bottom: 0.5px solid #e0e0e0;
        }

        .price-summary-list .selling-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 16px;
            border-bottom: 0.5px solid #f0f0f0;
            font-size: 13px;
        }

        .price-summary-list .selling-price:last-child {
            border-bottom: none;
        }

        .price-summary-list .selling-price label {
            font-weight: 600;
            color: #222;
            background: #f5f5f5;
            border: 0.5px solid #ddd;
            border-radius: 6px;
            padding: 3px 10px;
        }

        .price-summary-list .selling-price span {
            background: #E1F5EE;
            color: #085041;
            border: 0.5px solid #9FE1CB;
            border-radius: 20px;
            padding: 3px 12px;
            font-weight: 600;
            font-size: 12px;
        }

        .single-product-details-content-wrapper {
            padding-bottom: 30px;
        }

        .single-product-details-content-wrapper {
            padding-left: 0;
        }

        .gs-product-cards-slider-area .title {
            margin-bottom: 40px;
        }

        .tab-product-des-wrapper .nav-tabs .nav-link {
            padding: 0 20px;
        }

        .tab-pane {
            overflow: hidden;
        }

        .tab-pane img {
            max-width: 100%;
            height: auto;
        }

        .tab-pane table {
            width: 100%;
            display: block;
            overflow-x: auto;
        }

        .tab-pane p,
        .tab-pane span,
        .tab-pane div,
        .tab-pane li,
        .tab-pane td {
            overflow-wrap: break-word;
            word-break: break-word;
        }

        #description-tab-pane,
        #buy-return-policy-tab-pane {
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
        }

        #description-tab-pane *,
        #buy-return-policy-tab-pane * {
            max-width: 100%;
            overflow-wrap: break-word;
            word-break: break-word;
        }

        @media (max-width: 768px) {
            .tab-product-des-wrapper .nav-tabs .nav-link {
                padding: 0 10px;
            }
        }
    </style>
@endsection
@section('content')

    @php
        $cart = session('cart');

        $isOfferItem = false;

        if ($cart && $cart->items) {
            foreach ($cart->items as $cItem) {
                if ($cItem['item']->id == $productt->id) {
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

        $isOfferProduct = in_array($productt->sku, $offerMeta['all_offer_skus']);
        $isEligible = in_array($productt->sku, $offerMeta['eligible_offer_skus']);
    @endphp
    <!-- single product details content wrapper start -->
    <div class="single-product-details-content-wrapper">
        <div class="container">
            <div class="row gy-4">
                <div class="col-12">
                    <!-- product-breadcrumb -->
                    <!-- product-breadcrumb -->
                    <nav class="custom-breadcrumb mb-2 mb-lg-0">
                        <a href="{{ url('/') }}">Home</a>

                        {{-- Category --}}
                        @if ($productt->category)
                            <span class="separator"><i class="fa fa-chevron-right"></i></span>

                            @if ($productt->subcategory_id || $productt->childcategory_id)
                                <a href="{{ route('front.category', $productt->category->slug) }}">
                                    {{ $productt->category->name }}
                                </a>
                            @else
                                <span class="active">{{ $productt->category->name }}</span>
                            @endif
                        @endif

                        {{-- Subcategory --}}
                        @if ($productt->subcategory_id && $productt->subcategory)
                            <span class="separator"><i class="fa fa-chevron-right"></i></span>

                            @if ($productt->childcategory_id)
                                <a
                                    href="{{ route('front.category', [$productt->category->slug, $productt->subcategory->slug]) }}">
                                    {{ $productt->subcategory->name }}
                                </a>
                            @else
                                <span class="active">{{ $productt->subcategory->name }}</span>
                            @endif
                        @endif
                        {{-- child category --}}
                        @if ($productt->childcategory_id && $productt->childcategory_id)
                            <span class="separator"><i class="fa fa-chevron-right"></i></span>

                            @if ($productt->childcategory_id)
                                <a
                                    href="{{ route('front.category', [$productt->category->slug, $productt->subcategory->slug, $productt->childcategory->slug]) }}">
                                    {{ $productt->childcategory->name }}
                                </a>
                            @else
                                <span class="active">{{ $productt->childcategory->name }}</span>
                            @endif
                        @endif

                        {{-- product title --}}
                        @if ($productt->childcategory_id && $productt->childcategory)
                            <span class="separator"><i class="fa fa-chevron-right"></i></span>
                            <span class="active">{{ $productt->name }}</span>
                        @endif
                    </nav>
                </div>
                <!-- gs-product-details-gallery-wrapper -->
                <div class="col-lg-6 wow-replaced" data-wow-delay=".1s">
                    <div class="gs-product-details-gallery-wrapper">
                        <div class="product-main-slider">
                            <img src="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}"
                                alt="{{ $productt->name }}"
                                data-zoom-image="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}"
                                class="main-img glightbox" alt="gallery-img">
                            @foreach ($productt->galleries as $gal)
                                <img src="{{ asset('assets/images/galleries/' . $gal->photo) }}"
                                    data-image="{{ asset('assets/images/galleries/' . $gal->photo) }}" class="main-img"
                                    alt="gallery-img">
                            @endforeach
                        </div>

                        <div class="product-nav-slider">
                            <img src="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}"
                                alt="Thumb Image"
                                data-zoom-image="{{ filter_var($productt->photo, FILTER_VALIDATE_URL) ? $productt->photo : asset('assets/images/products/' . $productt->photo) }}"
                                class="nav-img" alt="gallery-img">
                            @foreach ($productt->galleries as $gal)
                                <img src="{{ asset('assets/images/galleries/' . $gal->photo) }}"
                                    data-image="{{ asset('assets/images/galleries/' . $gal->photo) }}" class="nav-img"
                                    alt="gallery-img">
                            @endforeach
                        </div>
                    </div>
                    <!--  tab-product-des-wrapper start -->
                    <div class="tab-product-des-wrapper wow-replaced d-none d-lg-block" data-wow-delay=".1s">
                        <div class="container">
                            <ul class="nav nav-tabs mb-0" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        data-bs-target="#description-tab-pane" type="button" role="tab"
                                        aria-controls="description-tab-pane" aria-selected="true">
                                        @lang('Description')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="buy-return-policy-tab" data-bs-toggle="tab"
                                        data-bs-target="#buy-return-policy-tab-pane" type="button" role="tab"
                                        aria-controls="buy-return-policy-tab-pane" aria-selected="false">
                                        @lang('Buy / Return Policy')
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                                        data-bs-target="#reviews-tab-pane" type="button" role="tab"
                                        aria-controls="reviews-tab-pane" aria-selected="false">
                                        @lang('Reviews')
                                    </button>
                                </li>

                                @if ($productt->whole_sell_qty != null && $productt->whole_sell_qty != '')
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="whole-sell-tab" data-bs-toggle="tab"
                                            data-bs-target="#whole-sell-tab-pane" type="button" role="tab"
                                            aria-controls="whole-sell-tab-pane" aria-selected="false">
                                            @lang('Whole sell')
                                        </button>
                                    </li>
                                @endif

                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane show active wow-replaced" data-wow-delay=".1s"
                                    id="description-tab-pane" role="tabpanel" aria-labelledby="description-tab"
                                    tabindex="0">
                                    {!! clean($productt->details, ['Attr.EnableID' => true]) !!}
                                </div>
                                <div class="tab-pane fade" id="buy-return-policy-tab-pane" role="tabpanel"
                                    aria-labelledby="buy-return-policy-tab" tabindex="0">
                                    {!! clean($productt->policy, ['Attr.EnableID' => true]) !!}
                                </div>

                                <!-- Reviews tab content start  -->
                                <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel"
                                    aria-labelledby="reviews-tab" tabindex="0">
                                    <div class="row review-tab-content-wrapper">
                                        <div class="col-xxl-8">
                                            <div id="comments">
                                                <h5 class="woocommerce-Reviews-titleDDD my-3"> @lang('Ratings & Reviews')</h5>
                                                <ul class="all-comments">
                                                    @forelse($productt->ratings() as $review)
                                                        <li>
                                                            <div class="single-comment">
                                                                <div class="left-area">
                                                                    <img src="{{ $review->user->photo ? asset('assets/images/users/' . $review->user->photo) : asset('assets/images/' . $gs->user_image) }}"
                                                                        alt="">
                                                                    <p class="name text-lg">
                                                                        {{ $review->user->name }}
                                                                    </p>
                                                                    <div class="reating-area">
                                                                        <div class="stars"><span
                                                                                id="star-rating">{{ $review->rating }}</span>
                                                                            <i class="fas fa-star"></i>
                                                                        </div>
                                                                        <p class="date">
                                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans() }}
                                                                        </p>
                                                                    </div>

                                                                </div>
                                                                <div class="right-area">
                                                                    <div class="comment-body">
                                                                        <p>
                                                                            {{ $review->review }}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @empty
                                                        <li>
                                                            <div class="single-comment">
                                                                <div class="left-area">
                                                                    <p class="name text-lg">
                                                                        @lang('No Review Found')
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </div>


                                            @if (Auth::check())
                                                <div id="review_form_wrapper">

                                                    <div class="review-area">

                                                        <h5 class="title">@lang('Reviews')</h5>
                                                        <div class="star-area">
                                                            <ul class="star-list">
                                                                <li class="stars" data-val="1">
                                                                    <i class="fas fa-star"></i>
                                                                </li>
                                                                <li class="stars" data-val="2">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </li>
                                                                <li class="stars" data-val="3">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </li>
                                                                <li class="stars" data-val="4">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </li>
                                                                <li class="stars active" data-val="5">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>


                                                    <div class="write-comment-area">

                                                        <form action="{{ route('front.review.submit') }}"
                                                            data-href="{{ route('front.reviews', $productt->id) }}"
                                                            data-side-href="{{ route('front.side.reviews', $productt->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <input type="hidden" id="rating" name="rating"
                                                                value="5">
                                                            <input type="hidden" name="user_id"
                                                                value="{{ Auth::user()->id }}">
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $productt->id }}">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <textarea name="review" placeholder="{{ __('Write Your Review *') }}" required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <button class="template-btn"
                                                                        type="submit">{{ __('Submit') }}</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <h5 class="text-center">
                                                    <a href="{{ route('user.login') }}" class="btn login-btn mr-1">
                                                        {{ __('Login') }}
                                                    </a>
                                                    {{ __('To Review') }}
                                                </h5>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                                <!-- Reviews tab content end -->

                                @if ($productt->whole_sell_qty != null && $productt->whole_sell_qty != '')
                                    <!-- Wholesell Tab content start  -->
                                    <div class="tab-pane fade" id="whole-sell-tab-pane" role="tabpanel"
                                        aria-labelledby="whole-sell-tab" tabindex="0">
                                        <div class="row sholesell-tab-content-wrapper">
                                            <div class="col-12 col-lg-8 col-xl-9 col-xxl-8">
                                                <div class="pro-summary ">
                                                    <div class="price-summary">
                                                        <div class="price-summary-content">
                                                            <p class="title text-center text-lg">@lang('Wholesell')</p>
                                                            <ul class="price-summary-list">
                                                                <li class="regular-price">
                                                                    <p class="fw-medium">@lang('Quantity')</p>
                                                                    <p class="fw-medium">
                                                                        @lang('Discount')
                                                                    </p>
                                                                </li>

                                                                @foreach ($productt->whole_sell_qty as $key => $data1)
                                                                    <li class="selling-price">
                                                                        <label>{{ $productt->whole_sell_qty[$key] }}+</label>
                                                                        <span><span
                                                                                class="woocommerce-Price-amount amount">{{ $productt->whole_sell_discount[$key] }}%
                                                                                @lang('Off')
                                                                            </span>
                                                                        </span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!--  tab-product-des-wrapper end -->
                </div>

                <div class="col-lg-6 wow-replaced" data-wow-delay=".2s">
                    <form>
                        <!-- product-info-wrapper  -->
                        <div class="product-info-wrapper  {{ $productt->type != 'Physical' ? 'mb-3' : '' }}">
                            <h1 class="h3">{{ $productt->name }}</h1>
                            @php
                                $basePrice =
                                    $productt->discount > 0
                                        ? \App\Helpers\PriceHelper::discountPrice(
                                            $productt->price,
                                            $productt->discount,
                                            $productt->discount_type,
                                        )
                                        : $productt->price;
                            @endphp
                            @if ($productt->stock > 0 || $productt->preordered == 2)
                                <div class="price-wrapper mb-3">
                                    @if ($productt->discount > 0)
                                        <h5 class="product-price current-price" data-base-price="{{ $basePrice }}">
                                            {{ \App\Helpers\PriceHelper::discountPrice($productt->price, $productt->discount, $productt->discount_type) }}
                                            ৳
                                        </h5>
                                        <h5 class="original-price">{{ $productt->price }} ৳</h5>
                                    @else
                                        <h5 class="product-price current-price" data-base-price="{{ $basePrice }}">
                                            {{ $productt->price }}
                                            ৳</h5>
                                    @endif


                                    @if ($productt->discount > 0)
                                        @if ($productt->discount_type == 'percent')
                                            <span class="discount-pill">
                                                {{ $productt->discount }} % ছাড়
                                            </span>
                                        @elseif($productt->discount_type == 'flat')
                                            <span class="discount-pill">
                                                {{ $productt->discount }} ৳ ছাড়
                                            </span>
                                        @endif
                                    @endif



                                    @if ($productt->measure)
                                        <h6 class="measure-product">
                                            / Per
                                            <select class="measure-select" data-measure-type="{{ $productt->measure }}">
                                                @if ($productt->measure == 'KG')
                                                    <option value="1">1kg</option>
                                                    <option value="0.5">500gm</option>
                                                    <option value="0.25">250gm</option>
                                                @elseif($productt->measure == 'LTR')
                                                    <option value="1">1L</option>
                                                    <option value="0.5">500ml</option>
                                                    <option value="0.25">250ml</option>
                                                @elseif($productt->measure == 'PCS')
                                                    <option value="1">1p</option>
                                                    <option value="5">5p</option>
                                                    <option value="10">10p</option>
                                                @endif
                                            </select>
                                        </h6>
                                    @endif
                                    <input type="hidden" id="product-id" data-base-pid="{{ $productt->id }}"
                                        value="{{ $productt->id }}">

                                </div>
                            @endif


                        </div>
                        <div>
                            {{-- add to cart button --}}
                            @if ($productt->type == 'Physical')

                                @if (is_array($productt->size))
                                    <input type="hidden" id="stock" value="{{ $productt->size_qty[0] }}">
                                @else
                                    @if (!$productt->emptyStock())
                                        @if ($productt->stock_check == 1)
                                            <input type="hidden" id="stock" value="{{ $productt->size_price[0] }}">
                                        @else
                                            <input type="hidden" id="stock" value="{{ $productt->stock }}">
                                        @endif
                                    @elseif($productt->type != 'Physical')
                                        <input type="hidden" id="stock" value="0">
                                    @else
                                        <input type="hidden" id="stock" value="">
                                    @endif
                                @endif

                            @endif

                            <input type="hidden" id="product_price"
                                value="{{ round($productt->vendorPrice() * $curr->value, 2) }}">
                            <input type="hidden" id="product_id" value="{{ $productt->id }}">
                            <input type="hidden" id="product_discount" value="{{ $productt->discount }}">
                            <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
                            <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">

                            @php
                                $cart = Session::has('cart') ? Session::get('cart') : null;
                                $existingQty = 0;
                                $uniqueKey = null;

                                if ($cart && $cart->items) {
                                    foreach ($cart->items as $key => $cItem) {
                                        if ($cItem['item']->id == $productt->id) {
                                            $existingQty = $cItem['qty'];
                                            $uniqueKey = $cItem['unique_key'];
                                            break;
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

                                $isOfferProduct = in_array($productt->sku, $offerMeta['all_offer_skus']);
                                $isEligible = in_array($productt->sku, $offerMeta['eligible_offer_skus']);
                            @endphp


                            <!-- add to cart buy btn wrapper -->
                            @if ($productt->stock <= 0)
                                <div class="outofstock">
                                    @if ($productt->preordered == 2)
                                        <h5>{{ __('Request a product !') }}</h5>
                                    @else
                                        <h5>{{ __('Out of Stock !') }}</h5>
                                    @endif
                                </div>
                            @endif


                            @if ($productt->stock > 0 || $productt->preordered == 2)
                                @if (!$isOfferProduct || ($isOfferProduct && $isEligible && !$hasOfferInCart))
                                    @if ($existingQty == 0)
                                        {{-- SHOW ADD TO BAG --}}
                                        <div class="w-100 d-block mt-auto add-btn-wrapper">
                                            <button
                                                class="btn btn-sm add-cart-btn btn-info d-flex d-block w-100 justify-content-center align-items-center add_cart_details"
                                                data-href="{{ route('product.add.to.cart', $productt->id) }}"
                                                data-product-id="{{ $productt->id }}">
                                                <i class="fa fa-bolt mr-2" aria-hidden="true"> </i> Add To Cart
                                            </button>
                                        </div>
                                    @else
                                        {{-- SHOW QTY BOX --}}
                                        <div class="qty-box mt-auto qty-wrapper-normal"
                                            data-product-id="{{ $productt->id }}" data-unique-key="{{ $uniqueKey }}">
                                            <button type="button" class="qty-btn qty-minus"><i
                                                    class="fas fa-minus"></i></button>
                                            <span class="qty-text">{{ $existingQty }}</span>
                                            <button type="button" class="qty-btn qty-plus"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    @endif
                                @endif
                            @endif
                            {{-- add to cart button --}}
                        </div>
                        <div>
                            {{-- Flash Deal Timer --}}
                            @if ($productt->start_date != null && $productt->end_date != null)
                                <div class="mb-4 product-countdown mt-3" data-start="{{ $productt->start_date }}"
                                    data-end="{{ $productt->end_date }}">

                                    <div class="flash-sale-badge">
                                        <i class="ti ti-bolt"></i> Flash Sale ends in
                                    </div>

                                    <div class="flash-timer-wrap">
                                        <div class="flash-block">
                                            <span class="flash-num" data-unit="days">00</span>
                                            <span class="flash-label">Days</span>
                                        </div>
                                        <span class="flash-sep">:</span>
                                        <div class="flash-block">
                                            <span class="flash-num" data-unit="hours">00</span>
                                            <span class="flash-label">Hours</span>
                                        </div>
                                        <span class="flash-sep">:</span>
                                        <div class="flash-block">
                                            <span class="flash-num" data-unit="mins">00</span>
                                            <span class="flash-label">Minutes</span>
                                        </div>
                                        <span class="flash-sep">:</span>
                                        <div class="flash-block">
                                            <span class="flash-num" data-unit="secs">00</span>
                                            <span class="flash-label">Seconds</span>
                                        </div>
                                    </div>

                                </div>
                            @endif
                            {{-- Flash Deal Timer --}}
                        </div>

                        <!-- product stocks -->
                        @if (
                            $productt->ship != null ||
                                $productt->sku != null ||
                                $productt->platform != null ||
                                $productt->region != null ||
                                $productt->licence_type != null)
                            <div class="product-stocks-wraper">
                                <div class="product-meta-flex">

                                    @if ($productt->type == 'Physical')
                                        <div class="product-meta-item">
                                            <span class="meta-label">@lang('Availability')</span>
                                            @if ($productt->emptyStock())
                                                <span class="stock-availability out-stock">{{ __('Out Of Stock') }}</span>
                                            @else
                                                <span class="badge bg-success text-white py-0">{{ __('In Stock') }}</span>
                                            @endif
                                        </div>
                                    @endif

                                    @if ($productt->sku != null)
                                        <div class="product-meta-item">
                                            <span class="meta-label">@lang('SKU')</span>
                                            <span class="meta-value">{{ $productt->sku }}</span>
                                        </div>
                                    @endif

                                    @if ($productt->ship != null)
                                        <div class="product-meta-item" style="flex-basis: 100%">
                                            <span class="meta-label">@lang('Estimated Shipping')</span>
                                            <span class="meta-value">{{ $productt->ship }}</span>
                                        </div>
                                    @endif

                                    @if ($productt->type == 'License')
                                        @if ($productt->platform != null)
                                            <div class="product-meta-item">
                                                <span class="meta-label">@lang('Platform')</span>
                                                <span class="meta-value">{{ $productt->platform }}</span>
                                            </div>
                                        @endif
                                        @if ($productt->region != null)
                                            <div class="product-meta-item">
                                                <span class="meta-label">@lang('Region')</span>
                                                <span class="meta-value">{{ $productt->region }}</span>
                                            </div>
                                        @endif
                                        @if ($productt->licence_type != null)
                                            <div class="product-meta-item">
                                                <span class="meta-label">@lang('License Type')</span>
                                                <span class="meta-value">{{ $productt->licence_type }}</span>
                                            </div>
                                        @endif
                                    @endif

                                </div>
                            </div>
                        @endif
                        @if (!empty($productt->attributes))
                            @php
                                $attrArr = json_decode($productt->attributes, true);
                            @endphp
                        @endif

                        @if (!empty($attrArr))
                            <hr>
                            <div class="row gy-4">
                                @foreach ($attrArr as $attrKey => $attrVal)
                                    @if (array_key_exists('details_status', $attrVal) && $attrVal['details_status'] == 1)
                                        <div class="col-lg-6">
                                            <div class="attribute-wrapper">
                                                <span class="attribute-title">{{ str_replace('_', ' ', $attrKey) }}
                                                    :</span>
                                                <ul>
                                                    @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                                        <li class="gs-radio-wrapper">
                                                            <input type="radio"
                                                                id="{{ $attrKey }}{{ $optionKey }}"
                                                                data-key="{{ $attrKey }}"
                                                                data-price = "{{ $attrVal['prices'][$optionKey] * $curr->value }}"
                                                                value="{{ $optionVal }}" name="{{ $attrKey }}"
                                                                {{ $loop->first ? 'checked' : '' }} class="cart_attr">
                                                            <label class="icon-label" for="w1">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                                    height="20" viewBox="0 0 20 20" fill="none">
                                                                    <rect x="0.5" y="0.5" width="19" height="19"
                                                                        rx="9.5" fill="#FDFDFD" />
                                                                    <rect x="0.5" y="0.5" width="19" height="19"
                                                                        rx="9.5" stroke="#EE1243" />
                                                                    <circle cx="10" cy="10" r="4"
                                                                        fill="#EE1243" />
                                                                </svg>
                                                            </label>
                                                            <label for="{{ $attrKey }}{{ $optionKey }}">
                                                                {{ $optionVal }}
                                                                @if (!empty($attrVal['prices'][$optionKey]))
                                                                    +
                                                                    {{ $curr->sign }}
                                                                    {{ $attrVal['prices'][$optionKey] * $curr->value }}
                                                                @endif
                                                            </label>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                            <hr>
                        @endif


                        @if ($productt->stock_check == 1)
                            @if (!empty($productt->size))
                                <!-- product size -->
                                <div class="variation-wrapper variation-sizes">
                                    <span class="varition-title">@lang('Size :')</span>
                                    <ul>
                                        @foreach (array_unique($productt->size) as $key => $data1)
                                            <li class="{{ $loop->first ? 'active' : '' }} cart_size"
                                                data-price="{{ $productt->size_price[$key] * $curr->value }}">
                                                <input {{ $loop->first ? 'checked' : '' }} type="radio"
                                                    id="size_{{ $key }}" data-value="{{ $key }}"
                                                    data-key="{{ str_replace(' ', '', $data1) }}"
                                                    data-price="{{ $productt->size_price[$key] * $curr->value }}"
                                                    data-qty="{{ $productt->size_qty[$key] }}"
                                                    value="{{ $key }}" name="size">
                                                <label for="size_{{ $key }}">{{ $data1 }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif


                            @if (!empty($productt->color_all))
                                <!-- product colors -->
                                <div class="variation-wrapper variation-colors">
                                    <span class="varition-title">@lang('Color :')</span>
                                    <ul>
                                        @foreach ($productt->color_all as $ckey => $color1)
                                            <li class="{{ $loop->first ? 'active' : '' }} cart_color">
                                                <input {{ $loop->first ? 'checked' : '' }} type="radio" data-price="0"
                                                    data-color="{{ $color1 }}" id="color_{{ $ckey }}"
                                                    name="colors" value="{{ $ckey }}">
                                                <label for="color_{{ $ckey }}"
                                                    data-color-code="{{ $color1 }}"
                                                    data-outline-color-code="{{ $color1 }}"></label>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            @endif

                        @endif





                        <div class="promoOfferWrap">
                            <div class="promoOfferLabel">
                                🎁 বিশেষ অফার
                            </div>
                            <div class="promoOfferList">

                                <div class="promoOfferCard promoOfferCard--green">
                                    <div class="promoOfferAccent"></div>
                                    <div class="promoOfferBody">
                                        <div class="promoOfferIcon">🥔</div>
                                        <div class="promoOfferText">
                                            <div class="promoOfferThreshold">১০০০ টাকার কেনাকাটায়</div>
                                            <div class="promoOfferDesc">২ কেজি তাজা আলু পাবেন</div>
                                        </div>
                                        <div class="promoOfferBadge">বিনামূল্যে</div>
                                    </div>
                                </div>

                                <div class="promoOfferCard promoOfferCard--amber">
                                    <div class="promoOfferAccent"></div>
                                    <div class="promoOfferBody">
                                        <div class="promoOfferIcon">🥩</div>
                                        <div class="promoOfferText">
                                            <div class="promoOfferThreshold">১৫০০ টাকার কেনাকাটায়</div>
                                            <div class="promoOfferDesc">গরুর মাংসের মসলা পাবেন</div>
                                        </div>
                                        <div class="promoOfferBadge">মাত্র ১ ৳</div>
                                    </div>
                                </div>

                                <div class="promoOfferCard promoOfferCard--blue">
                                    <div class="promoOfferAccent"></div>
                                    <div class="promoOfferBody">
                                        <div class="promoOfferIcon">🥚</div>
                                        <div class="promoOfferText">
                                            <div class="promoOfferThreshold">২০০০ টাকার বেশি কেনাকাটায়</div>
                                            <div class="promoOfferDesc">১ ডজন ডিম পাবেন</div>
                                        </div>
                                        <div class="promoOfferBadge">মাত্র ১ ৳</div>
                                    </div>
                                </div>

                                <div class="promoOfferCard promoOfferCard--coral">
                                    <div class="promoOfferAccent"></div>
                                    <div class="promoOfferBody">
                                        <div class="promoOfferIcon">🛢️</div>
                                        <div class="promoOfferText">
                                            <div class="promoOfferThreshold">২৫০০ টাকার বেশি কেনাকাটায়</div>
                                            <div class="promoOfferDesc">১ লিটার সয়াবিন তেল পাবেন</div>
                                        </div>
                                        <div class="promoOfferBadge">মাত্র ১ ৳</div>
                                    </div>
                                </div>

                                <div class="promoOfferCard promoOfferCard--pink">
                                    <div class="promoOfferAccent"></div>
                                    <div class="promoOfferBody">
                                        <div class="promoOfferIcon">🛒</div>
                                        <div class="promoOfferText">
                                            <div class="promoOfferThreshold">৫০০০ টাকার কেনাকাটায়</div>
                                            <div class="promoOfferDesc">২ লিটার সয়াবিন তেল পাবেন</div>
                                        </div>
                                        <div class="promoOfferBadge">মাত্র ২ ৳</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <script async src="https://static.addtoany.com/menu/page.js"></script>
                        <!-- store & seller -->

                        <div class="product-video-content-area">
                            @php

                                $videoUrl = $productt->video_url;
                                $embedUrl = '';
                                $width = '100%'; // Default width
                                $height = '500'; // Default height
                                $col = '6'; // Default col
                                $ratio = '56.25%'; // default (16:9)

                                if (strpos($videoUrl, 'facebook.com') !== false) {
                                    if (strpos($videoUrl, '/reel/') !== false) {
                                        // Facebook Reel URL
                                        $videoId = explode('/reel/', $videoUrl)[1];
                                        $videoId = explode('?', $videoId)[0];
                                        $embedUrl = "https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/watch/?v={$videoId}";
                                        $height = '800'; // Facebook Reel height
                                        $col = '4';
                                        $ratio = '177.77%'; // 9:16 (vertical video)
                                    } elseif (
                                        strpos($videoUrl, 'watch?v=') !== false ||
                                        strpos($videoUrl, '/watch/') !== false
                                    ) {
                                        // Facebook Watch Video URL
                                        if (strpos($videoUrl, 'v=') !== false) {
                                            $videoId = explode('v=', $videoUrl)[1];
                                        } else {
                                            $videoId = explode('/watch/', $videoUrl)[1];
                                        }
                                        $videoId = explode('&', $videoId)[0]; // Remove trailing query parameters
                                        $embedUrl = "https://www.facebook.com/plugins/video.php?href=https://www.facebook.com/watch/?v={$videoId}";
                                        $height = '530'; // Facebook Watch video height
                                        $ratio = '177.77%'; // 9:16 (vertical video)
                                    }
                                } elseif (
                                    strpos($videoUrl, 'youtube.com') !== false ||
                                    strpos($videoUrl, 'youtu.be') !== false
                                ) {
                                    if (strpos($videoUrl, 'youtube.com/watch') !== false) {
                                        // Standard YouTube Video URL
                                        $videoId = explode('v=', $videoUrl)[1];
                                        $videoId = explode('&', $videoId)[0];
                                        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                                    } elseif (strpos($videoUrl, 'youtu.be') !== false) {
                                        // Shortened YouTube URL
                                        $videoId = explode('/', $videoUrl)[3];
                                        $videoId = explode('?', $videoId)[0];
                                        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                                    } elseif (strpos($videoUrl, '/embed/') !== false) {
                                        // YouTube Embed URL
                                        $embedUrl = $videoUrl;
                                    } elseif (strpos($videoUrl, 'shorts') !== false) {
                                        // YouTube Shorts URL
                                        //https://www.youtube.com/shorts/zIDDpjTJRjU?feature=share
                                        $videoId = explode('/', $videoUrl)[4];
                                        $videoId = explode('?', $videoId)[0];
                                        $embedUrl = "https://www.youtube.com/shorts/{$videoId}";
                                    }
                                    // Adjust height for YouTube Shorts
                                    if (strpos($videoUrl, 'shorts') !== false) {
                                        $height = '700'; // YouTube Shorts height
                                        $col = '4';
                                    }
                                }
                            @endphp

                            @if ($embedUrl)
                                <div style="position: relative; width: 100%; padding-top: {{ $ratio }};">
                                    <iframe
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0;"
                                        src="{{ $embedUrl }}" title="Video Player"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- single product details content wrapper end -->
    <!--  tab-product-des-wrapper start -->
    <div class="tab-product-des-wrapper wow-replaced d-block d-lg-none" data-wow-delay=".1s">
        <div class="container">
            <ul class="nav nav-tabs mb-0" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                        data-bs-target="#description-tab-pane" type="button" role="tab"
                        aria-controls="description-tab-pane" aria-selected="true">
                        @lang('Description')
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="buy-return-policy-tab" data-bs-toggle="tab"
                        data-bs-target="#buy-return-policy-tab-pane" type="button" role="tab"
                        aria-controls="buy-return-policy-tab-pane" aria-selected="false">
                        @lang('Buy / Return Policy')
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews-tab-pane"
                        type="button" role="tab" aria-controls="reviews-tab-pane" aria-selected="false">
                        @lang('Reviews')
                    </button>
                </li>

                @if ($productt->whole_sell_qty != null && $productt->whole_sell_qty != '')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="whole-sell-tab" data-bs-toggle="tab"
                            data-bs-target="#whole-sell-tab-pane" type="button" role="tab"
                            aria-controls="whole-sell-tab-pane" aria-selected="false">
                            @lang('Whole sell')
                        </button>
                    </li>
                @endif

            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane show active wow-replaced" data-wow-delay=".1s" id="description-tab-pane"
                    role="tabpanel" aria-labelledby="description-tab" tabindex="0">
                    {!! clean($productt->details, ['Attr.EnableID' => true]) !!}
                </div>
                <div class="tab-pane fade" id="buy-return-policy-tab-pane" role="tabpanel"
                    aria-labelledby="buy-return-policy-tab" tabindex="0">
                    {!! clean($productt->policy, ['Attr.EnableID' => true]) !!}
                </div>

                <!-- Reviews tab content start  -->
                <div class="tab-pane fade" id="reviews-tab-pane" role="tabpanel" aria-labelledby="reviews-tab"
                    tabindex="0">
                    <div class="row review-tab-content-wrapper">
                        <div class="col-xxl-8">
                            <div id="comments">
                                <h5 class="woocommerce-Reviews-titleDDD my-3"> @lang('Ratings & Reviews')</h5>
                                <ul class="all-comments">
                                    @forelse($productt->ratings() as $review)
                                        <li>
                                            <div class="single-comment">
                                                <div class="left-area">
                                                    <img src="{{ $review->user->photo ? asset('assets/images/users/' . $review->user->photo) : asset('assets/images/' . $gs->user_image) }}"
                                                        alt="">
                                                    <p class="name text-lg">
                                                        {{ $review->user->name }}
                                                    </p>
                                                    <div class="reating-area">
                                                        <div class="stars"><span
                                                                id="star-rating">{{ $review->rating }}</span>
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <p class="date">
                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $review->review_date)->diffForHumans() }}
                                                        </p>
                                                    </div>

                                                </div>
                                                <div class="right-area">
                                                    <div class="comment-body">
                                                        <p>
                                                            {{ $review->review }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li>
                                            <div class="single-comment">
                                                <div class="left-area">
                                                    <p class="name text-lg">
                                                        @lang('No Review Found')
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>


                            @if (Auth::check())
                                <div id="review_form_wrapper">

                                    <div class="review-area">

                                        <h5 class="title">@lang('Reviews')</h5>
                                        <div class="star-area">
                                            <ul class="star-list">
                                                <li class="stars" data-val="1">
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="2">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="3">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars" data-val="4">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                                <li class="stars active" data-val="5">
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="write-comment-area">

                                        <form action="{{ route('front.review.submit') }}"
                                            data-href="{{ route('front.reviews', $productt->id) }}"
                                            data-side-href="{{ route('front.side.reviews', $productt->id) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" id="rating" name="rating" value="5">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <textarea name="review" placeholder="{{ __('Write Your Review *') }}" required></textarea>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <button class="template-btn"
                                                        type="submit">{{ __('Submit') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <h5 class="text-center">
                                    <a href="{{ route('user.login') }}" class="btn login-btn mr-1">
                                        {{ __('Login') }}
                                    </a>
                                    {{ __('To Review') }}
                                </h5>
                            @endif

                        </div>
                    </div>
                </div>
                <!-- Reviews tab content end -->

                @if ($productt->whole_sell_qty != null && $productt->whole_sell_qty != '')
                    <!-- Wholesell Tab content start  -->
                    <div class="tab-pane fade" id="whole-sell-tab-pane" role="tabpanel" aria-labelledby="whole-sell-tab"
                        tabindex="0">
                        <div class="row sholesell-tab-content-wrapper">
                            <div class="col-12 col-lg-8 col-xl-9 col-xxl-8">
                                <div class="pro-summary ">
                                    <div class="price-summary">
                                        <div class="price-summary-content">
                                            <p class="title text-center text-lg">@lang('Wholesell')</p>
                                            <ul class="price-summary-list">
                                                <li class="regular-price">
                                                    <p class="fw-medium">@lang('Quantity')</p>
                                                    <p class="fw-medium">
                                                        @lang('Discount')
                                                    </p>
                                                </li>

                                                @foreach ($productt->whole_sell_qty as $key => $data1)
                                                    <li class="selling-price">
                                                        <label>{{ $productt->whole_sell_qty[$key] }}+</label>
                                                        <span><span
                                                                class="woocommerce-Price-amount amount">{{ $productt->whole_sell_discount[$key] }}%
                                                                @lang('Off')
                                                            </span>
                                                        </span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!--  tab-product-des-wrapper end -->

    <!-- Related Products slider start -->
    <div class="gs-product-cards-slider-area wow-replaced py-0 pt-4" data-wow-delay=".1s">
        <div class="container">
            <h2 class="title text-center">@lang('Related Products')</h2>
            <div class="product-cards-slider">
                @php
                    $query = App\Models\Product::query()
                        ->where('product_type', $productt->product_type)
                        ->withCount('ratings')
                        ->withAvg('ratings', 'rating');

                    if ($productt->childcategory_id) {
                        $query->where('childcategory_id', $productt->childcategory_id);
                    } elseif ($productt->subcategory_id) {
                        $query->where('subcategory_id', $productt->subcategory_id);
                    } else {
                        $query->where('category_id', $productt->category_id);
                    }

                    // Fetch 12 random related products
                    $related_products = $query->inRandomOrder()->take(12)->get();
                @endphp
                @foreach ($related_products as $product)
                    @include('includes.frontend.home_product', ['class' => 'not'])
                @endforeach
            </div>
        </div>
    </div>
    <!-- Related Products slider end -->

    <!-- More Products By Seller slider start -->
    @if ($productt->user_id != 0 && $vendor_products->count() > 0)
        <div class="gs-product-cards-slider-section more-products-by-seller  wow-replaced" data-wow-delay=".1s">
            <div class="gs-product-cards-slider-area more-products-by-seller">
                <div class="container">
                    <h2 class="title text-center">@lang('More Products By Seller')</h2>
                    <div class="product-cards-slider">
                        @foreach ($vendor_products as $product)
                            @include('includes.frontend.home_product', ['class' => 'not'])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- More Products By Seller slider end -->





    <!-- Product report Modal Start -->
    @if (auth()->check())
        <div class="modal gs-modal fade" id="report-modal" tabindex="-1" aria-hidden="true">
            <form action="{{ route('product.report') }}" method="POST"
                class="modal-dialog assign-rider-modal-dialog modal-dialog-centered">
                {{ csrf_field() }}
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                <input type="hidden" name="product_id" value="{{ $productt->id }}">

                <div class="modal-content assign-rider-modal-content form-group">
                    <div class="modal-header w-100">
                        <h4 class="title">{{ __('REPORT PRODUCT') }}</h4>
                        <button type="button" data-bs-dismiss="modal">
                            <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                        </button>

                    </div>
                    <!-- modal body start  -->
                    <!-- Select Rider -->
                    <div class="input-label-wrapper w-100">
                        <label>{{ __('Please give the following details') }}</label>
                        <input type="text" name="title" class="form-control mb-3"
                            placeholder="{{ __('Enter Report Title') }}" required="">

                        <textarea name="note" class="form-control border  p-3" placeholder="{{ __('Enter Report Note') }}"
                            required=""></textarea>



                    </div>

                    <!-- Assign Rider Button  -->
                    <button class="template-btn" data-bs-dismiss="modal" type="submit">{{ __('SUBMIT') }}</button>
                    <!-- modal body end  -->
                </div>
            </form>
        </div>
    @endif
    <!-- Product report Modal End -->



    {{-- MESSAGE MODAL ENDS --}}

    {{-- MESSAGE MODAL ENDS --}}


    <div class="modal gs-modal fade" id="vendorform" tabindex="-1" aria-modal="true" role="dialog">
        <form action="{{ route('user-send-message') }}" id="emailreply" method="POST"
            class="modal-dialog assign-rider-modal-dialog modal-dialog-centered emailreply">
            {{ csrf_field() }}
            <div class="modal-content assign-rider-modal-content form-group">
                <div class="modal-header w-100">
                    <h4 class="title">@lang('Send Message')</h4>
                    <button type="button" data-bs-dismiss="modal">
                        <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                    </button>

                </div>
                <!-- modal body start  -->
                <!-- Select Rider -->
                <div class="input-label-wrapper w-100">

                    <input type="text" class="form-control  border px-3 mb-4" id="eml" name="email"
                        name="subject" readonly placeholder="@lang('Select Rider')"
                        value="{{ auth()->user() ? auth()->user()->email : '' }}">
                    <input type="text" class="form-control  border px-3 mb-4" name="subject"
                        placeholder="@lang('Subject')" required="">

                    <textarea class="form-control  border px-3 mb-4" name="message" placeholder="{{ __('Your Message') }}"
                        required=""></textarea>

                    <input type="hidden" name="name" value="{{ Auth::user() ? Auth::user()->name : '' }}">
                    <input type="hidden" name="user_id" value="{{ Auth::user() ? Auth::user()->id : '' }}">
                    <input type="hidden" name="vendor_id" value="{{ $productt->user_id }}">

                </div>
                <!-- Select Pickup Point -->

                <!-- Assign Rider Button  -->
                <button class="template-btn" data-bs-dismiss="modal" type="submit">@lang('Send Message')</button>
                <!-- modal body end  -->
            </div>
        </form>
    </div>




    <div class="modal gs-modal fade" id="sendMessage" tabindex="-1" aria-modal="true" role="dialog">
        <form action="{{ route('user-send-message') }}" method="POST"
            class="modal-dialog assign-rider-modal-dialog modal-dialog-centered emailreply">
            {{ csrf_field() }}
            <div class="modal-content assign-rider-modal-content form-group">
                <div class="modal-header w-100">
                    <h4 class="title">@lang('Send Message')</h4>
                    <button type="button" data-bs-dismiss="modal">
                        <i class="fa-regular fa-circle-xmark gs-modal-close-btn"></i>
                    </button>

                </div>
                <!-- modal body start  -->

                <div class="input-label-wrapper w-100">

                    <div class="dropdown-container">
                        <input type="text" class="form-control form__control border px-3 mb-4" name="subject"
                            placeholder="@lang('Subject')" required="">

                        <textarea class="form-control form__control border px-3 mb-4" name="message" placeholder="{{ __('Your Message') }}"
                            required=""></textarea>
                    </div>
                </div>

                <button class="template-btn" data-bs-dismiss="modal" type="submit">
                    @lang('Send Message')
                </button>
                <!-- modal body end  -->
            </div>
        </form>
    </div>





@endsection

@section('script')
    <script src="{{ asset('assets/front/js/jquery.elevatezoom.js') }}"></script>

    <!-- Initializing the slider -->


    <script type="text/javascript">
        (function($) {
            "use strict";

            //initiate the plugin and pass the id of the div containing gallery images
            $("#single-image-zoom").elevateZoom({
                gallery: 'gallery_09',
                zoomType: "inner",
                cursor: "crosshair",
                galleryActiveClass: 'active',
                imageCrossfade: true,
                loadingIcon: 'http://www.elevateweb.co.uk/spinner.gif'
            });
            //pass the images to Fancybox
            $("#single-image-zoom").bind("click", function(e) {
                var ez = $('#single-image-zoom').data('elevateZoom');
                $.fancybox(ez.getGalleryList());
                return false;
            });

            $(document).on("submit", "#emailreply", function() {
                var token = $(this).find('input[name=_token]').val();
                var subject = $(this).find('input[name=subject]').val();
                var message = $(this).find('textarea[name=message]').val();
                var email = $(this).find('input[name=email]').val();
                var name = $(this).find('input[name=name]').val();
                var user_id = $(this).find('input[name=user_id]').val();
                $('#eml').prop('disabled', true);
                $('#subj').prop('disabled', true);
                $('#msg').prop('disabled', true);
                $('#emlsub').prop('disabled', true);
                $.ajax({
                    type: 'post',
                    url: "{{ URL::to('/user/user/contact') }}",
                    data: {
                        '_token': token,
                        'subject': subject,
                        'message': message,
                        'email': email,
                        'name': name,
                        'user_id': user_id
                    },
                    success: function(data) {
                        $('#eml').prop('disabled', false);
                        $('#subj').prop('disabled', false);
                        $('#msg').prop('disabled', false);
                        $('#subj').val('');
                        $('#msg').val('');
                        $('#emlsub').prop('disabled', false);
                        if (data == 0)
                            toastr.error("Email Not Found");
                        else
                            toastr.success("Message Sent");
                        $('#vendorform').modal('hide');
                    }
                });
                return false;
            });

        })(jQuery);

        $('.add-to-affilate').on('click', function() {

            var value = $(this).data('href');
            var tempInput = document.createElement("input");
            tempInput.style = "position: absolute; left: -1000px; top: -1000px";
            tempInput.value = value;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand("copy");
            document.body.removeChild(tempInput);
            toastr.success('Affiliate Link Copied');

        });
    </script>
@endsection
