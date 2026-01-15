<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Essential css files-->
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/all.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/slick.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/nice-select.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/animate.css">
    <link rel="stylesheet" href="{{ asset('assets/front/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/datatables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/style.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/custom.css">

    <link rel="icon" href="{{ asset('assets/images/' . $gs->favicon) }}">
    @include('includes.frontend.extra_head')
    @yield('css')
    <style>
        .header-top {
            padding: 15px 0;
        }

        .fa-whatsapp {
            color: #048835;
            background: #fff;
            padding: 3px 6px;
            font-size: 22px;
            border-radius: 7px;
        }

        .header-logo-wrapper>img {
            width: 142px;
        }

        .single-product .content-wrapper,
        .single-product-list-view .content-wrapper {
            height: auto;
            background: #ffff;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
            padding: 14px 13px !important;

        }

        .gs-breadcrumb-section {
            padding: 80px 0px;
            position: relative;
        }

        .gs-breadcrumb-section::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 0%;
            background-color: rgba(15, 42, 66, 0.5);
            z-index: 1;
        }

        .gs-hero-section {
            height: 400px;
        }

        .gs-cate-section {
            padding: 35px 0px;
        }

        .gs-offer-section .product-wrapper {
            border-radius: 20px;
            background: #ddd;
            overflow: hidden;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        }

        .gs-explore-product-section {
            padding: 22px 0px;
        }

        .gs-offer-section {
            padding-bottom: 52px;
        }

        .gs-footer-section .footer-row {
            padding-top: 30px;
            padding-bottom: 0px;
        }

        .gs-footer-section {
            background-color: #005862;
        }

        .gs-footer-section .gs-footer-bottom {
            background-color: #007182;
        }

        .gs-single-cat {
            background: #ffffff;
            border-radius: 12px;
        }

        .gs-single-cat .cate-img {
            width: 190px;
            height: 190px;
            padding: 2px;
            border: 0px solid #858585;
            border-radius: 23px;
            margin-bottom: 4px;
        }

        .gs-single-cat {
            background: #2cc1db;
            border-radius: 12px;
        }

        .gs-single-cat .title {
            margin-bottom: 4px;
            color: #fff;
            font-size: 18px;
        }

        .single-product .add-cart,
        .single-product-list-view .add-cart {
            width: 110px;
        }

        .single-product .add-to-cart,
        .single-product-list-view .add-to-cart {
            gap: 5px;
        }

        .measure-product {
            color: #888888 !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            margin-top: 5px;
        }

        .single-product .img-wrapper .product-badge,
        .single-product-list-view .img-wrapper .product-badge {
            width: 70px;
            padding: 3px 6px;
            border-radius: 4px;
            background: #1bb9cb;
            font-size: 12px;
            font-weight: 600;
        }

        .outofstock-box {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
        }

        .outofstock-box h5 {
            color: #fff;
            font-size: 16px;
            background: #eb4d4b;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .flash_timer {
            background: #fff12e;
            border: 2px solid #ff9800;
            border-radius: 8px;
            padding: 5px 5px;
            min-width: 80px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .single-product {
            border: 1px solid #ddd;
            border-radius: 10px
        }

        * .container {
            padding: 0 20px !important;
        }

        .searchResults::-webkit-scrollbar {
            width: 3px;
        }

        .searchResults::-webkit-scrollbar-thumb {
            background: #1bb9cb;
            border-radius: 10px;
        }

        .gs-partner-section .single-partner img {
            object-fit: contain;
        }

        .single-product .img-wrapper {
            background: #fff;
        }

        .mobile-offcanvas button:not(.collapsed) i.fa-plus {
            display: none;
        }

        .mobile-offcanvas button:not(.collapsed) i.fa-minus {
            display: inline-block;
        }

        .product-cat-widget {
            padding-top: 24px;
            padding-bottom: 90px !important;
        }

        .single-product:hover {
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
        }

        .gs-single-cat:hover .title {
            color: #fff;
        }

        .gs-single-cat .title {
            font-size: 16px !important;
        }

        .gs-single-cat .cate-img {
            object-fit: contain;
            max-width: 100%;
            height: auto;
        }

        .home-cate-slider .slick-slide {
            margin: 0 10px;
            /* total gap = 20px */
        }

        .home-cate-slider .slick-list {
            margin: 0 -10px;
        }

        .col-lg-2 {
            padding: 0 4px !important;
        }

        .whatsapp_div {
            position: static;
        }

        @media (max-width: 768px) {
            .whatsapp_div {
                position: relative;
                left: -30px;
            }

        }

        .outofstock-box-2 {
            background: rgba(0, 0, 0, 0.6) !important;
        }

        @media (max-width: 768px) {
            .gs-partner-section .col-xl-2 {
                flex: 0 0 auto;
                width: 33% !important;
            }

            .single-product .img-wrapper,
            .single-product-list-view .img-wrapper {
                overflow: hidden;
                position: relative;
                height: 127px !important;
                object-fit: contain !important;
            }

            .single-product .img-wrapper a {
                display: block;
                height: 100%;
                width: 100%;

            }

            .single-product .img-wrapper .product-img,
            .single-product-list-view .img-wrapper .product-img {
                width: 100%;
                height: 100% !important;
                object-fit: contain;
            }

        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/sidebar.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/customize.css">
    <!-- Meta Pixel Code -->

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NGVKWTDQ');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body class="overflow-auto" style="overflow: auto !important;">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NGVKWTDQ" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    @php
        $categories = App\Models\Category::with('subs')->where('status', 1)->get();
        $pages = App\Models\Page::get();
        $currencies = App\Models\Currency::all();
        $languges = App\Models\Language::all();
    @endphp
    <!-- header area -->
    {{-- @include('includes.frontend.header') --}}
    <header class="header shadow">
        <div class="container-fluid">
            <!-- Desktop Logo, Menubar, Search Start -->
            <div class="d-flex align-items-center justify-content-between px-1 px-lg-3 container-fluid">
                <div class="d-flex align-items-center gap-3 logo_Bar">
                    <div id="menu-btn" class="menu-icon active">
                        <i id="barIcon" class="fa-solid fa-bars-staggered"></i>
                    </div>
                    <a href="{{ route('front.index') }}">
                        <img src="{{ asset('assets/images/' . $gs->logo) }}" class="logo" />
                    </a>
                    <div class="whatsapp_div ">
                        <div class="d-flex align-items-center gap-2"><img style="width: 40px; height: auto;"
                                src="{{ asset('assets/front/images/whatsapp.png') }}" alt="whatsapp">
                            <div>
                                <a href="https://wa.me/8801805020340?text=Assalamu%20Alaikum,%20I%20want%20to%20order%20from%20your%20supershop."
                                    class="text-success fw-bold d-none d-lg-block">
                                    01805020340
                                </a>
                                <a class="text-success fw-bold d-none d-lg-block"
                                    href="https://wa.me/8801805020346?text=Assalamu%20Alaikum,%20I%20want%20to%20order%20from%20your%20supershop.">01805020346</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="search-box d-none d-lg-block">
                    <form action="{{ route('front.search') }}" method="GET">

                        <input autocomplete="off" type="text" name="search" class="searchInput"
                            placeholder="Search for products (e.g. milk, rice, meat, fish)" />
                    </form>
                    <!-- Search Result Box -->
                    <div style=" min-height: 0; max-height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    position: absolute;
    width: 100%;
    z-index: 9999;"
                        class="searchResults"></div>
                </div>


                @if (Auth::guard('web')->check())
                    <a class="btn login-btn" href="{{ route('user-dashboard') }}"><i class="fa fa-user-circle"
                            aria-hidden="true"></i> @lang('Dashboard')</a>
                @else
                    <a href="{{ route('user.login') }}" class="btn login-btn"> <i class="fa fa-sign-in"
                            aria-hidden="true"></i> @lang('Login')</a>
                @endif
            </div>
            <!-- Desktop Logo, Menubar, Search  End-->

            <!-- mobile search will appear below automatically -->
            <div class="search-box d-lg-none container">
                <form action="{{ route('front.search') }}" method="GET">

                    <input autocomplete="off" type="text" name="search" class="searchInput"
                        placeholder="Search for products " />
                </form>
                <div style="max-height: 300px;
    overflow-y: auto;
    overflow-x: hidden;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    position: absolute;
    width: 89%;
    z-index: 9999;"
                    class="searchResults"></div>
            </div>
        </div>
    </header>

    <!-- Desktop Sidebar Start -->
    <aside id="sidebar" class="sidebar active pt-4 shadow">

        <!-- Offers Section -->
        <div class="offers-container">
            <a href="{{ route('front.offers') }}" class="d-flex gap-2 align-items-center mb-2 ">
                <p style="font-size: 15px; color: #1bb9cb" class="pb-0 mb-0">
                    Offers
                    <span class="offer-outline-btn">
                        {{ App\Models\Product::where('discount', '>', 0)->count() }}
                    </span>
                    <img class="ms-3" style="width: 100px; height: auto;"
                        src="{{ asset('assets/front/images/offer.gif') }}" alt="best offer">
                </p>
            </a>
            {{-- <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0">Egg Club</p>
            </a> --}}
        </div>

        {{-- <div class="ps-3">
            <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0"><img src="{{ asset('assets/assets/images/icons/favourites.svg') }}" /> Favourites
                </p>
            </a>
            <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0"><img src="{{ asset('assets/assets/images/icons/winter-collection.webp') }}" />
                    Winter Collection</p>
            </a>
            <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0"><img src="{{ asset('assets/assets/images/icons/flash-sales.webp') }}" /> Flash
                    Sales</p>
            </a>
        </div> --}}

        <!-- MAIN ACCORDION -->
        <div class="product-cat-widget">
            <ul class="accordion">
                @foreach ($categories as $category)
                    @php
                        $isCategoryActive = Request::segment(2) === $category->slug;
                        $catId = 'cat_' . $category->slug . '_level_2';
                    @endphp

                    <li>
                        @if ($category->subs->count() > 0)
                            <div class="d-flex justify-content-between align-items-lg-baseline">
                                <a style="font-size: 16px;" href="{{ route('front.category', $category->slug) }}"
                                    class="{{ $isCategoryActive ? 'sidebar-active-color' : '' }}"
                                    data-collapse="#{{ $catId }}">
                                    <img class="rounded me-1" style="width: 30px"
                                        src="{{ asset('assets/images/categories') }}/{{ $category->image }}"
                                        alt=""> {{ $category->name }}
                                </a>

                                <button type="button" data-bs-toggle="collapse"
                                    data-bs-target="#{{ $catId }}"
                                    aria-expanded="{{ $isCategoryActive ? 'true' : 'false' }}"
                                    class="{{ $isCategoryActive ? '' : 'collapsed' }}">
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </button>
                            </div>

                            <ul id="{{ $catId }}"
                                class="accordion-collapse collapse ms-3 mt-2 {{ $isCategoryActive ? 'show' : '' }}">

                                @foreach ($category->subs as $subcategory)
                                    @php
                                        $isSubActive = $isCategoryActive && Request::segment(3) === $subcategory->slug;
                                        $subId = 'sub_' . $subcategory->slug . '_lvl2';
                                    @endphp

                                    <li>
                                        <div class="d-flex justify-content-between align-items-lg-baseline">

                                            <a href="{{ route('front.category', [$category->slug, $subcategory->slug]) }}"
                                                class="{{ $isSubActive ? 'sidebar-active-color' : '' }}"
                                                data-collapse="{{ $subcategory->childs->count() > 0 ? '#' . $subId : '' }}">
                                                {{ $subcategory->name }}
                                            </a>

                                            @if ($subcategory->childs->count() > 0)
                                                <button type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#{{ $subId }}"
                                                    aria-expanded="{{ $isSubActive ? 'true' : 'false' }}"
                                                    class="{{ $isSubActive ? '' : 'collapsed' }}">
                                                    <i class="fa-solid fa-plus"></i>
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>
                                            @endif

                                        </div>

                                        @if ($subcategory->childs->count() > 0)
                                            <ul id="{{ $subId }}"
                                                class="accordion-collapse collapse ms-3 mt-2 {{ $isSubActive ? 'show' : '' }}">
                                                @foreach ($subcategory->childs as $child)
                                                    @php
                                                        $isChildActive =
                                                            $isSubActive && Request::segment(4) === $child->slug;
                                                    @endphp

                                                    <li>
                                                        <a href="{{ route('front.category', [$category->slug, $subcategory->slug, $child->slug]) }}"
                                                            class="{{ $isChildActive ? 'sidebar-active-color' : '' }}">
                                                            {{ $child->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif

                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <a href="{{ route('front.category', $category->slug) }}"
                                class="{{ Request::segment(2) === $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

    </aside>
    <!-- Desktop Sidebar End -->

    <!-- Mobile Offcanvas Start-->
    <div id="mobile-offcanvas" class="mobile-offcanvas shadow ">
        <ul class="accordion">
            @foreach ($categories as $category)
                @php
                    $isCategoryActive = Request::segment(2) === $category->slug;
                    $catId = 'cat_' . $category->slug . '_level_2';
                @endphp

                <li>
                    @if ($category->subs->count() > 0)
                        <div class="d-flex justify-content-between align-items-lg-baseline">
                            <a style="font-size: 16px;" href="{{ route('front.category', $category->slug) }}"
                                class="{{ $isCategoryActive ? 'sidebar-active-color' : '' }}"
                                data-collapse="#{{ $catId }}">
                                <img class="rounded me-1" style="width: 30px"
                                    src="{{ asset('assets/images/categories') }}/{{ $category->image }}"
                                    alt=""> {{ $category->name }}
                            </a>

                            <button type="button" data-bs-toggle="collapse" data-bs-target="#{{ $catId }}"
                                aria-expanded="{{ $isCategoryActive ? 'true' : 'false' }}"
                                class="{{ $isCategoryActive ? '' : 'collapsed' }}">
                                <i class="fa-solid fa-plus"></i>
                                <i class="fa-solid fa-minus"></i>
                            </button>
                        </div>

                        <ul id="{{ $catId }}"
                            class="accordion-collapse collapse ms-3 {{ $isCategoryActive ? 'show' : '' }}">

                            @foreach ($category->subs as $subcategory)
                                @php
                                    $isSubActive = $isCategoryActive && Request::segment(3) === $subcategory->slug;
                                    $subId = 'sub_' . $subcategory->slug . '_lvl2';
                                @endphp

                                <li>
                                    <div class="d-flex justify-content-between align-items-lg-baseline">

                                        <a href="{{ route('front.category', [$category->slug, $subcategory->slug]) }}"
                                            class="{{ $isSubActive ? 'sidebar-active-color' : '' }}"
                                            data-collapse="{{ $subcategory->childs->count() > 0 ? '#' . $subId : '' }}">
                                            {{ $subcategory->name }}
                                        </a>

                                        @if ($subcategory->childs->count() > 0)
                                            <button type="button" data-bs-toggle="collapse"
                                                data-bs-target="#{{ $subId }}"
                                                aria-expanded="{{ $isSubActive ? 'true' : 'false' }}"
                                                class="{{ $isSubActive ? '' : 'collapsed' }}">
                                                <i class="fa-solid fa-plus"></i>
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        @endif

                                    </div>

                                    @if ($subcategory->childs->count() > 0)
                                        <ul id="{{ $subId }}"
                                            class="accordion-collapse collapse ms-3 {{ $isSubActive ? 'show' : '' }}">
                                            @foreach ($subcategory->childs as $child)
                                                @php
                                                    $isChildActive =
                                                        $isSubActive && Request::segment(4) === $child->slug;
                                                @endphp

                                                <li>
                                                    <a href="{{ route('front.category', [$category->slug, $subcategory->slug, $child->slug]) }}"
                                                        class="{{ $isChildActive ? 'sidebar-active-color' : '' }}">
                                                        {{ $child->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a href="{{ route('front.category', $category->slug) }}"
                            class="{{ Request::segment(2) === $category->slug ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>

    </div>
    <!-- Mobile Offcanvas End-->



    <!-- if route is user panel then show vendor.mobile-header else show frontend.mobile_menu -->

    @php
        $url = url()->current();
        $explodeUrl = explode('/', $url);

    @endphp

    @if (in_array('user', $explodeUrl))
        <!-- frontend mobile menu -->
        @include('includes.user.mobile-header')
    @elseif(in_array('rider', $explodeUrl))
        @include('includes.rider.mobile-header')
    @else
        @include('includes.frontend.mobile_menu')
        <!-- user panel mobile sidebar -->
    @endif


    <div class="overlay"></div>
    <!-- Main Content -->
    <main id="main-content" class="main-content">

        @yield('content')

        <div class="container product-cart-offcanvas position-relative">
            <div class="text-end position-fixed" style="right: 1%; top: 50%; z-index: 999">
                @php
                    $cartObject = Session::has('cart') ? Session::get('cart') : null;
                    $cartItems = $cartObject ? $cartObject->items : [];
                @endphp

                <div class="cart-wrapper  anim" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight">
                    <div class="cart-top">
                        <img style="height: 40px; width: auto" src="{{ asset('assets/front/images/bag.gif ') }}"
                            alt="bag" />
                        <p><span class="cart-count">{{ $cartItems ? count($cartItems) : 0 }}</span> Item</p>
                    </div>

                    <div class="cart-bottom">
                        <p>৳ <span class="total_price">{{ $cartObject ? $cartObject->totalPrice : 0 }}</span></p>
                    </div>
                </div>

            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel" data-bs-backdrop="false" data-bs-scroll="true">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel" class="mb-0 d-flex align-items-center">
                        <img style="height: 40px; width: auto" src="{{ asset('assets/front/images/bag.gif ') }}"
                            alt="" />
                        <span class="cart-total-item"><span
                                class="cart-count">{{ $cartItems ? count($cartItems) : 0 }} </span> ITEMS</span>
                    </h5>

                    <button type="button" class="close-text-btn btn border-2 btn-outline-light"
                        data-bs-dismiss="offcanvas">
                        Close
                    </button>
                </div>
                <div class="offcanvas-body p-0">
                    <!-- Free Delivery info Message -->
                    {{-- <div class="alert py-1 px-0 my-0 alert-success rounded-0" role="alert">
                        <strong style="font-size: 12px; padding-left: 5px">Free Home Delivery on orders over
                            ৳1000!</strong>
                        <i class="fas fa-info-circle ms-2 d-inline-block"></i>
                    </div> --}}
                    <!-- Super Express Delivery -->
                    <div style="background-color: #eee" class="p-1">
                        <img style="height: 40px; width: auto"
                            src="{{ asset('/assets/front/images/fast-delivery.png') }}" alt="fast delivery" />
                        <strong style="font-size: 13px; margin-left: 8px">We deliver within 1 to 2 hours.</strong>
                    </div>
                    <!-- Cart Items Start  -->
                    <div class="offCanva-right-cartItems">
                        @include('includes.frontend.offcanvas-cart')
                    </div>
                    <!-- Cart Items end -->
                    <!-- cart footer start -->
                    <a href="{{ route('front.checkout') }}" class="order-btn">
                        <span class="order-text">Place Order</span>
                        <span class="order-price total_price">{{ $cartObject ? $cartObject->totalPrice : 0 }}</span>
                    </a>
                    <!-- cart footer end -->
                </div>
                <div class="left-close">
                    <button data-bs-dismiss="offcanvas" title="close">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- cart offcanvas End -->

        <!-- footer section -->
        @include('includes.frontend.footer')
        <!-- footer section -->
    </main>



    <!--Esential Js Files-->
    <script src="{{ asset('assets/front') }}/js/jquery.min.js"></script>
    <script src="{{ asset('assets/front') }}/js/slick.js"></script>
    <script src="{{ asset('assets/front') }}/js/jquery-ui.js"></script>
    <script src="{{ asset('assets/front') }}/js/nice-select.js"></script>

    <script src="{{ asset('assets/front') }}/js/wow.js"></script>
    <script src="{{ asset('assets/front') }}/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>

    <script src="{{ asset('assets/front') }}/js/script.js"></script>
    <script src="{{ asset('assets/front/js/myscript.js') }}"></script>


    <script>
        "use strict";
        var mainurl = "{{ url('/') }}";
        var gs = {!! json_encode(
            DB::table('generalsettings')->where('id', '=', 1)->first(['is_loader', 'decimal_separator', 'thousand_separator', 'is_cookie', 'is_talkto', 'talkto']),
        ) !!};
        var ps_category = {{ $ps->category }};

        var lang = {
            'days': '{{ __('Days') }}',
            'hrs': '{{ __('Hrs') }}',
            'min': '{{ __('Min') }}',
            'sec': '{{ __('Sec') }}',
            'cart_already': '{{ __('Already Added To Card.') }}',
            'cart_out': '{{ __('Out Of Stock') }}',
            'cart_success': '{{ __('Successfully Added To Cart.') }}',
            'cart_empty': '{{ __('Cart is empty.') }}',
            'coupon_found': '{{ __('Coupon Found.') }}',
            'no_coupon': '{{ __('No Coupon Found.') }}',
            'already_coupon': '{{ __('Coupon Already Applied.') }}',
            'enter_coupon': '{{ __('Enter Coupon First') }}',
            'minimum_qty_error': '{{ __('Minimum Quantity is:') }}',
            'affiliate_link_copy': '{{ __('Affiliate Link Copied Successfully') }}'
        };
    </script>



    @php
        if (Session::has('success')) {
            echo '<script>
                toastr.success("'.Session::get('success').'")
            </script>';
        }
        if (Session::has('unsuccess')) {
            echo '<script>
                toastr.error("'.Session::get('unsuccess').'")
            </script>';
        }
    @endphp
    <!--Start of Tawk.to Script-->
    {{-- --<script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/68ce640071624f1929ac0656/1j5j3d8mt';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>--- --}}
    <!--End of Tawk.to Script-->

    @yield('script')
    @stack('scripts')
    <script>
        $(function() {
            $(".countdown").each(function() {
                var $this = $(this);
                var startDate = new Date($this.data("start") + " 00:00:00").getTime();
                var endDate = new Date($this.data("end") + " 23:59:59").getTime();
                var $timer = $this.find(".flash_timer");

                var interval = setInterval(function() {
                    var now = new Date().getTime();

                    if (now < startDate) {
                        $timer.html("⏳ Deal Not Started Yet!");
                        return;
                    }

                    if (now > endDate) {
                        clearInterval(interval);
                        $timer.html("⚡ Deal Expired!");
                        return;
                    }

                    var distance = endDate - now;

                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    $timer.text(
                        (days < 10 ? "0" + days : days) + ":" +
                        (hours < 10 ? "0" + hours : hours) + ":" +
                        (minutes < 10 ? "0" + minutes : minutes) + ":" +
                        (seconds < 10 ? "0" + seconds : seconds) + " Left"
                    );
                }, 1000);
            });
        });
    </script>

    <script>
        const searchInputs = document.querySelectorAll('.searchInput');

        searchInputs.forEach(input => {
            const parentBox = input.parentElement.parentElement;
            const searchResults = parentBox.querySelector('.searchResults');

            let typingTimer;
            const typingDelay = 200;

            input.addEventListener('keyup', function() {
                clearTimeout(typingTimer);
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                typingTimer = setTimeout(() => {
                    fetch(`{{ route('front.ajax.search') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(products => {
                            if (products.length > 0) {
                                let html = '';
                                products.forEach(p => {
                                    const productUrl =
                                        `{{ route('front.product', ':slug') }}`
                                        .replace(':slug', p.slug);

                                    html += `
                                <div class="search-item">
                                    <a href="${productUrl}">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('/assets/images/thumbnails') }}/${p.thumbnail}"
                                            alt="" style="width:40px;height:40px;margin-right:10px;">
                                            <div>
                                                <strong>${p.name}</strong><br>
                                                <span>৳ ${parseFloat(p.price).toFixed(2)}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>`;
                                });

                                searchResults.innerHTML = html;
                                searchResults.style.display = 'block';
                            } else {
                                searchResults.innerHTML =
                                    `<div class="search-item">No products found</div>`;
                                searchResults.style.display = 'block';
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            searchResults.style.display = 'none';
                        });
                }, typingDelay);
            });

            // Hide when clicked outside
            document.addEventListener('click', function(e) {
                if (!searchResults.contains(e.target) && e.target !== input) {
                    searchResults.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.measure-select').forEach(select => {

                select.addEventListener('change', function() {

                    const selectedOption = this.options[this.selectedIndex];

                    const measureValue = parseFloat(selectedOption.value || 1);
                    const measurePrice = parseFloat(selectedOption.dataset.price || 0);

                    const wrapper = this.closest('.price-wrapper');
                    const priceElement = wrapper.querySelector('.product-price');

                    const basePrice = parseFloat(priceElement.dataset.basePrice);

                    let finalPrice = 0;

                    // 1️⃣ If admin set price per measure → use it
                    if (measurePrice > 0) {
                        finalPrice = measurePrice;
                    }
                    // 2️⃣ Otherwise calculate from base price
                    else {
                        finalPrice = basePrice * measureValue;
                    }

                    priceElement.textContent = finalPrice.toFixed(2) + '৳';
                });

            });

        });
    </script>
    <script>
        $(document).ready(function() {
            // ======================
            // MENU BUTTON TOGGLE
            // ======================
            $("#menu-btn").click(function() {

                if (window.innerWidth < 992) {

                    $("#mobile-offcanvas").toggleClass("active");
                    $("#barIcon").toggleClass("fa-bars-staggered fa-x");
                    $(window).resize(function() {
                        if (window.innerWidth >= 992) {
                            // Reset icon to bar
                            $("#barIcon").removeClass("fa-x").addClass("fa-bars-staggered");

                            // Offcanvas hide
                            $("#mobile-offcanvas").removeClass("active");
                        }
                    });

                } else {
                    // Desktop Sidebar Toggle
                    $("#sidebar").toggleClass("active");

                    if ($("#sidebar").hasClass("active")) {
                        $("#sidebar").css("left", "0");
                        $("#main-content").css("margin-left", "230px");
                    } else {
                        $("#sidebar").css("left", "-230px");
                        $("#main-content").css("margin-left", "0");
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Show offcanvas if last state was "open"
            if (localStorage.getItem("offcanvasCart") === "open") {
                let myOffcanvas = new bootstrap.Offcanvas("#offcanvasRight");
                myOffcanvas.show();
            }

            // When user opens the offcanvas → save state
            document.getElementById("offcanvasRight").addEventListener("shown.bs.offcanvas", function() {
                localStorage.setItem("offcanvasCart", "open");
            });

            // When user closes the offcanvas → save state
            document.getElementById("offcanvasRight").addEventListener("hidden.bs.offcanvas", function() {
                localStorage.setItem("offcanvasCart", "closed");
            });
        });
    </script>
</body>

</html>
