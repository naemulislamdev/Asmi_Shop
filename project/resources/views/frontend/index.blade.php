@extends('layouts.front')

@section('content')
    <style>
        .gs-hero-section img {
            width: 100%;
            height: 100%;
            /* You can adjust this height based on your design */
            background-size: cover;
            /* Ensures the image fills the area */
            background-position: center;
            /* Keeps focus on the center */
            background-repeat: no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        .gs-hero-section {
            height: auto;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .gs-hero-section {
                height: 160px;
            }

            .gs-hero-section img {
                height: 100%;
                /* Smaller height for mobile */
                background-position: center top;
            }
        }
    </style>
    <style>
        .flash-deal {
            background: url('assets/front/images/weeklyoffer-bg.png');
            /* border: 2px solid #ff9800; */
            border-radius: 10px;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 100% 100%;
        }

        .countdown-box .time-box {
            background: #fff;
            border: 2px solid #ff9800;
            border-radius: 8px;
            padding: 5px 5px;
            min-width: 80px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .countdown-box span {
            font-size: 17px;
            font-weight: bold;
            color: #e65100;
            display: block;
        }

        .countdown-box small {
            font-size: 14px;
            color: #555;
        }

        .gs-partner-section .col-xl-2 {
            flex: 0 0 auto;
            width: 16%;
        }

        .slider-section .card img {
            border-radius: 10px !important;
        }

        /* hero slider change styel */
        .hero-slider-wrapper .slick-prev {
            left: 0%;
            background-color: rgba(27, 185, 203, 0.4);
            /* Blur effect */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            /* for Safari */
        }

        .hero-slider-wrapper .slick-next {
            right: 0%;
            background-color: rgba(27, 185, 203, 0.4);
            /* Blur effect */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            /* for Safari */
        }

        .hero-slider-wrapper .slick-next:hover,
        .hero-slider-wrapper .slick-prev:hover {
            background: #1bb9cb;
        }

        .slider-section .left-promo .card,
        .slider-section .right-promo .card {
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 6px -1px, rgba(0, 0, 0, 0.06) 0px 2px 4px -1px;
        }

        .home-coupon-slider .coupon-item img {
            max-width: 100%;
            height: auto;
        }

        /* Previous arrow */
        .home-coupon-slider .slick-prev {
            background-color: rgba(27, 185, 203, 0.4);
            color: #1bb9cb;
            height: 30px;
            width: 30px;
            line-height: 30px;
            border-radius: 50%;
            position: absolute;
            top: 35%;
            left: 0;
            /* adjust distance from left */
            z-index: 999;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            border: 2px solid #1bb9cb;
            /* Blur effect */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            /* for Safari */
        }

        /* Next arrow */
        .home-coupon-slider .slick-next {
            background-color: rgba(27, 185, 203, 0.4);
            color: #1bb9cb;
            height: 30px;
            width: 30px;
            line-height: 30px;
            border-radius: 50%;
            position: absolute;
            top: 35%;
            right: -5px;
            /* adjust distance from right */
            z-index: 999;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            border: 2px solid #1bb9cb;
            /* Blur effect */
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            /* for Safari */
        }

        /* Optional: remove default arrows background on hover */
        .home-coupon-slider .slick-prev:hover,
        .home-coupon-slider .slick-next:hover {
            background-color: #17a1b1;
            color: #fff;
        }

        .left-promo .slick-track {
            transform: translate3d(0, 0, 0) !important;
        }

        .left-promo .slick-slide {
            width: 100% !important;
        }

        .left-promo .slick-dots,
        .right-promo .slick-dots {
            margin-top: 0;
        }

        .left-promo .slick-dots li.slick-active button {
            width: 30px;
        }

        .right-promo .slick-dots li.slick-active button {
            width: 30px;
        }

        /* 22 Feb 26 */
        .hero-slider .swiper-horizontal>.swiper-pagination-bullets,
        .hero-slider .swiper-pagination-bullets.swiper-pagination-horizontal,
        .hero-slider .swiper-pagination-custom,
        .hero-slider .swiper-pagination-fraction {
            bottom: -1px !important;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
            background: rgba(0, 0, 0, 0.5);
            width: 35px;
            height: 35px;
            border-radius: 50%;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 18px;
            font-weight: bold;
        }

        .category-item {
            background: #fff;
            border-radius: 8px;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 0.0625em 0.0625em, rgba(0, 0, 0, 0.25) 0px 0.125em 0.5em, rgba(255, 255, 255, 0.1) 0px 0px 0px 1px inset;
            text-align: center;
            padding-bottom: 0;
        }

        .category-item img {
            max-width: 100%;
            height: auto;
            border-radius: 8px 8px 0 0;
        }

        /* wrapper stretch */
        .home-category-slider .swiper-wrapper {
            align-items: stretch;
        }

        /* slide full height */
        .home-category-slider .swiper-slide {
            height: auto;
            display: flex;
        }

        /* link full height */
        .slide-link {
            display: flex;
            width: 100%;
        }

        /* card full height */
        .gs-single-cat {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;

            background: #fff;
            box-shadow: rgba(0, 0, 0, 0.05) 0px 0px 0px 1px, rgb(209, 213, 219) 0px 0px 0px 1px inset;
        }

        /* image fixed height */
        .cate-img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        /* title bottom align */
        .cate-title {
            margin-top: auto;
            text-align: center;
        }

        .swiper-pagination-bullet {
            width: var(--swiper-pagination-bullet-width,
                    var(--swiper-pagination-bullet-size, 12px));
            height: var(--swiper-pagination-bullet-height,
                    var(--swiper-pagination-bullet-size, 12px));
        }

        .swiper-pagination-bullet-active {
            background: #1bb9cb !important;
        }
    </style>

    <!-- hero section start -->

    <section class="slider-section">
        <div class="row ">
            <div class="@if ($promoOffers->count() > 0) col-lg-2 @endif d-none d-lg-block p-0">
                <div class="left-promo">

                    @foreach ($left_promo_offers->chunk(2) as $chunk)
                        {{-- ONE SLIDE --}}
                        <div class="left-promo-wrapper d-flex flex-column gap-3">

                            @foreach ($chunk as $item)
                                <div class="card border-0">
                                    <a href="{{ $item->link }}">
                                        <img class="card-img-top slider-side-img"
                                            src="{{ asset('assets/images/sliders/' . $item->photo) }}" alt="">
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    @endforeach

                </div>
            </div>

            <div class="@if ($promoOffers->count() > 0) col-lg-8 @else col-lg-12 @endif  px-0">
                <div class=" ">

                    <div class="hero-slider">
                        <div class="container">
                            <!-- Swiper -->
                            <div class="swiper heroSlider" style="">
                                <div class="swiper-wrapper">
                                    @foreach ($sliders as $slider)
                                        <div class="swiper-slide rounded">
                                            <a href="{{ $slider->link ?? '#' }}" target="_blank" rel="noopener noreferrer">
                                                <img style="max-width: 100%; height: auto;" class="rounded"
                                                    src="{{ asset('assets/images/sliders/' . $slider->photo) }}"
                                                    alt="slider image">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Pagination -->
                                <div class="swiper-pagination"></div>

                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="@if ($promoOffers->count() > 0) col-lg-2 @endif d-none d-lg-block ps-0">
                <div class="right-promo">

                    @foreach ($right_promo_offers->chunk(2) as $chunk)
                        {{-- ONE SLIDE --}}
                        <div class="right-promo-wrapper d-flex flex-column gap-3">

                            @foreach ($chunk as $item)
                                <div class="card border-0">
                                    <a href="{{ $item->link }}">
                                        <img class="card-img-top slider-side-img"
                                            src="{{ asset('assets/images/sliders/' . $item->photo) }}" alt="">
                                    </a>
                                </div>
                            @endforeach

                        </div>
                    @endforeach

                </div>
            </div>

        </div>

    </section>

    <!-- hero section end -->

    {{-- Coupon slider section start --}}
    @if ($coupon_sliders->count() > 0)
        <section class="mt-4">
            <div class="container">
                <div class="home-coupon-slider">
                    @foreach ($coupon_sliders as $slider)
                        <div class="coupon-item">
                            <a href="{{ $slider->link }}">
                                <img src="{{ asset('assets/images/sliders/coupon/' . $slider->image) }}" alt="coupon image">
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif
    {{-- Coupon slider section end --}}

    <!-- categories section start -->
    <div class="gs-cate-section py-2">
        <div class="container">
            <!-- title box -->
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="gs-title-box text-center">
                        <h2 class="title wow-replaced">
                            @lang('Categories') </h2>
                    </div>
                </div>
            </div>
            <div class="d-none d-lg-block">
                <div class="swiper home-category-slider">
                    <div class="swiper-wrapper">

                        @foreach ($featured_categories as $fcategory)
                            <div class="swiper-slide">
                                <a href="{{ route('front.category', $fcategory->slug) }}" class="slide-link">

                                    <div class="gs-single-cat">
                                        <img class="cate-img"
                                            src="{{ asset('assets/images/categories/' . $fcategory->image) }}"
                                            alt="category img">
                                        <div class="cate-title">
                                            <h6 class="title text-dark">{{ $fcategory->name }}</h6>
                                        </div>
                                    </div>

                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
            {{-- for mobile and tablet --}}
            <div class="d-block d-lg-none">
                <div class="row">
                    @foreach ($featured_categories as $fcategory)
                        <div class="col-4 col-sm-4 d-flex mb-3 px-1">
                            <a href="{{ route('front.category', $fcategory->slug) }}"
                                class="category-item w-100 position-relative">

                                <img class="cate-img" src="{{ asset('assets/images/categories/' . $fcategory->image) }}"
                                    alt="category img">

                                <div class="cate-title py-2 w-100">
                                    <h6 class="title mb-0 mt-2 text-dark">{{ $fcategory->name }}</h6>
                                </div>

                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Deal Countdown Section -->
    @php
        use Carbon\Carbon;

        $flashDeal = \App\Models\FlashDeal::where('status', 1)->first();
        $flashDealExpired = false;
        $flashDealProducts = [];

        if ($flashDeal) {
            $ProductsId = json_decode($flashDeal->products);
            $flashDealProducts = \App\Models\Product::whereIn('id', $ProductsId)->where('status', 1)->get();
            $flashDealExpired = Carbon::now()->gt(Carbon::parse($flashDeal->end_date));
        }
    @endphp

    @if ($flashDeal && !$flashDealExpired)
        {{-- 🟢 Flash deal active: show it at the top --}}
        @include('includes.frontend.flash_deal', [
            'flashDeal' => $flashDeal,
            'flashDealProducts' => $flashDealProducts,
        ])
    @endif

    {{-- 🟢 Featured products always show --}}
    @include('includes.frontend.featured_products', ['popular_products' => $popular_products])
    @if ($flashDeal && $flashDealExpired)
        {{-- 🔴 Flash deal expired: show it at the bottom --}}
        @include('includes.frontend.flash_deal', [
            'flashDeal' => $flashDeal,
            'flashDealProducts' => $flashDealProducts,
        ])
    @endif

    <!-- categories section end -->
    @if ($ps->arrival_section == 1)
        <!-- product offer section start -->
        <section class="gs-offer-section">
            <div class="container">
                <!-- title box -->
                <div class="row mb-60 justify-content-center">
                    <div class="col-lg-7">
                        <div class="gs-title-box text-center">
                            <h2 class="title wow-replaced">
                                @lang('Best Month offer') </h2>
                        </div>
                    </div>
                </div>

                <!-- main content -->
                <div class="row gy-4">
                    <div class="col-lg-4  wow-replaced" data-wow-delay=".2s">
                        <div class="product-wrapper">
                            <a href="{{ $arrivals[0]['url'] }}" class="">
                                <div class="single-offer-product">
                                    <img class="promo-img"
                                        src="{{ asset('assets/images/arrival/' . $arrivals[0]['photo']) }}"
                                        alt="offer product">
                                </div>
                            </a>
                        </div>

                    </div>
                    <!-- show over lg device -->
                    <div class="col-lg-4">
                        <div class="product-wrapper">
                            <a href="{{ $arrivals[1]['url'] }}" class="wow-replaced">
                                <div class="single-offer-product">
                                    <img class="promo-img"
                                        src="{{ asset('assets/images/arrival/' . $arrivals[1]['photo']) }}"
                                        alt="offer product">
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="product-wrapper">
                            <a href="{{ $arrivals[2]['url'] }}" class="wow-replaced">
                                <div class="single-offer-product">
                                    <img class="promo-img"
                                        src="{{ asset('assets/images/arrival/' . $arrivals[2]['photo']) }}"
                                        alt="offer product">

                                </div>
                            </a>
                        </div>
                    </div>
                    <!-- show below lg device -->
                </div>
            </div>
        </section>
        <!-- product offer section end -->
    @endif
    <!-- explore product section start -->
    <section class="gs-explore-product-section" style="background: #ededed">
        <div class="container">
            <!-- title box  & nav-tab -->
            <div class="row mb-36 justify-content-center">
                <div class="col-12">
                    <div class="gs-title-box text-center">
                        <h2 class="title wow-replaced">@lang('Explore Our Products')</h2>
                    </div>
                    <!-- product nav  -->
                    <ul class="nav explore-tab-navbar wow-replaced" data-wow-delay=".1s" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ex-product-1" data-bs-toggle="tab"
                                data-bs-target="#ex-product-1-pane" type="button" role="tab"
                                aria-controls="ex-product-1-pane" aria-selected="true">@lang('NEW ARRIVAL')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ex-product-2" data-bs-toggle="tab"
                                data-bs-target="#ex-product-2-pane" type="button" role="tab"
                                aria-controls="ex-product-2-pane" aria-selected="false">@lang('TRENDING')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ex-product-3" data-bs-toggle="tab"
                                data-bs-target="#ex-product-3-pane" type="button" role="tab"
                                aria-controls="ex-product-3-pane" aria-selected="false">@lang('BEST SELLING')</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ex-product-4" data-bs-toggle="tab"
                                data-bs-target="#ex-product-4-pane" type="button" role="tab"
                                aria-controls="ex-product-4-pane" aria-selected="false">@lang('POPULAR')</button>
                        </li>


                    </ul>
                </div>
            </div>


            <!-- tab content -->
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="ex-product-1-pane" role="tabpanel"
                    aria-labelledby="ex-product-1" tabindex="0">
                    <div class="row gy-4">
                        @foreach ($latest_products as $product)
                            @include('includes.frontend.home_product')
                        @endforeach
                    </div>
                </div>


                <div class="tab-pane fade" id="ex-product-2-pane" role="tabpanel" aria-labelledby="ex-product-2"
                    tabindex="0">

                    <div class="row gy-4">
                        @foreach ($trending_products as $product)
                            @include('includes.frontend.home_product')
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="ex-product-3-pane" role="tabpanel" aria-labelledby="ex-product-3"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($best_products as $product)
                            @include('includes.frontend.home_product')
                        @endforeach
                    </div>
                </div>

                <div class="tab-pane fade" id="ex-product-4-pane" role="tabpanel" aria-labelledby="ex-product-4"
                    tabindex="0">
                    <div class="row gy-4">
                        @foreach ($popular_products as $product)
                            @include('includes.frontend.home_product')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- explore product section end -->
    <!-- Category wise product Section Started -->
    @if ($featured_categories->count() > 0)
        @foreach ($featured_categories as $fcategory)
            @php
                $categoryWiseProducts = App\Models\Product::where('category_id', $fcategory->id)
                    ->where('status', 1)
                    ->take(12)
                    ->inRandomOrder()
                    ->get();
            @endphp
            @if ($categoryWiseProducts->count() > 0)
                <section class="gs-explore-product-section bg-white">
                    <div class="container">
                        <!-- title box  & nav-tab -->
                        <div class="row mb-36 justify-content-center">
                            <div class="col-12">
                                <div class="gs-title-box text-center">
                                    <h2 class="title wow-replaced">{{ $fcategory->name }}</h2>
                                </div>
                            </div>
                        </div>

                        <!-- tab content -->
                        <div class="tab-content" id="myTabContent1">
                            <div class="tab-pane fade show active wow-replaced" data-wow-delay=".1s"
                                id="ex-product-5-pane" role="tabpanel" aria-labelledby="ex-product-1" tabindex="0">
                                <div class="product-cards-slider">
                                    @foreach ($categoryWiseProducts as $product)
                                        @include('includes.frontend.home_product')
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endforeach
    @endif
    <!-- Category wise product Section Completed -->

    <!-- Faetured Products Section Started -->
    <section class="gs-explore-product-section bg-white">
        <div class="container">
            <!-- title box  & nav-tab -->
            <div class="row mb-36 justify-content-center">
                <div class="col-12">
                    <div class="gs-title-box text-center">
                        <h2 class="title wow-replaced">@lang('Our Featured Products')</h2>
                    </div>
                </div>
            </div>
            <!-- tab content -->
            <div class="tab-content" id="myTabContent1">
                <div class="tab-pane fade show active wow-replaced" data-wow-delay=".1s" id="ex-product-5-pane"
                    role="tabpanel" aria-labelledby="ex-product-1" tabindex="0">
                    <div class="product-cards-slider">
                        @foreach ($popular_products as $product)
                            @include('includes.frontend.home_product')
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Featured Product Section Completed -->
    <!-- Partner Section -->
    <section class="gs-partner-section">
        <div class="container">
            <div class="gs-partnerss gy-4 row justify-content-center">

                @foreach (DB::table('partners')->get() as $data)
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-6 col-6 wow-replaced" data-wow-delay=".1s">
                        <div class="single-partner">
                            <img src="{{ asset('assets/images/partner/' . $data->photo) }}" alt="partner">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </section>
    <!-- Partner Section Completed -->

    <!-- Explore Product Section -->
    <section class="gs-explore-product-section bg-light-white">
        <div class="container">
            <!-- title box  & nav-tab -->
            <div class="row mb-36 justify-content-center">
                <div class="col-12">
                    <div class="gs-title-box text-center">
                        <h2 class="title wow-replaced">@lang('Best Selling Products')</h2>
                    </div>
                </div>
            </div>

            <!-- tab content -->
            <div class="product-cards-slider">

                @foreach ($best_products as $product)
                    @include('includes.frontend.home_product')
                @endforeach
            </div>

        </div>
    </section>
    <!-- Explore Product Section Completed -->


    @if ($ps->blog == 1)
        <!-- Latest Post Section  -->
        <section class="gs-latest-post-section py-120">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="gs-title-box text-center">
                            <h2 class="title wow-replaced">@lang('Latest Post') </h2>
                            <p class="des mb-0 wow-replaced" data-wow-delay=".1s">@lang('Cillum eu id enim aliquip aute ullamco
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    anim. Culpa
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       deserunt
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            nostrud excepteur voluptate velit ipsum esse enim.')</p>
                        </div>
                    </div>
                </div>
                <div class="row gy-5 latest-post-area m-0">
                    @foreach ($blogs as $blog)
                        <div class="col-lg-6 posts-area wow-replaced" data-wow-delay=".2s">
                            <a href="{{ route('front.blogshow', $blog->slug) }}" class="single-post">
                                <div class="post-img">
                                    <img src="{{ asset('assets/images/blogs/' . $blog->photo) }}" alt="post">
                                </div>
                                <div class="post-content">
                                    <h4 class="post-title">
                                        {{ Str::limit($blog->title, 60) }}
                                    </h4>
                                    <p class="date">{{ date('d M, Y', strtotime($blog->created_at)) }}</p>
                                    <p class="post-desc">
                                        {{ mb_strlen(strip_tags($blog->details), 'UTF-8') > 150
                                            ? mb_substr(strip_tags($blog->details), 0, 150, 'UTF-8') . '...'
                                            : strip_tags($blog->details) }}
                                    </p>
                                    <span class="read-more">@lang('Read More')</span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("[data-background]").forEach(function(el) {
                const bg = el.getAttribute("data-background");
                if (bg) {
                    el.style.backgroundImage = `url('${bg}')`;
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".home-slider").forEach(function(img) {
                img.addEventListener("click", function() {
                    let url = this.getAttribute("data-href");
                    if (url) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {
            // ✅ Get start & end date dynamically from DB
            var startDate = new Date("{{ $flashDeal->start_date ?? '' }} 00:00:00").getTime();
            var endDate = new Date("{{ $flashDeal->end_date ?? '' }} 23:59:59").getTime();

            var timer = setInterval(function() {
                var now = new Date().getTime();

                // 1️⃣ Before start date
                if (now < startDate) {
                    $("#countdown").html("<h3>⏳ Deal Not Started Yet!</h3>");
                    return;
                }

                // 2️⃣ After end date
                if (now > endDate) {
                    clearInterval(timer);
                    $("#countdown").html("<h3>⚡ Deal Expired!</h3>");
                    return;
                }

                // 3️⃣ Countdown running
                var distance = endDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $("#days").text(days < 10 ? "0" + days : days);
                $("#hours").text(hours < 10 ? "0" + hours : hours);
                $("#minutes").text(minutes < 10 ? "0" + minutes : minutes);
                $("#seconds").text(seconds < 10 ? "0" + seconds : seconds);
            }, 1000);
        });
    </script>
@endpush
