<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $gs->title }}</title>
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
            height: 123px;
            background: #f5f5f5;
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

        .single-product .img-wrapper,
        .single-product-list-view .img-wrapper {
            border: 0px solid #e5e5e5;
        }

        .single-product .img-wrapper .product-img,
        .single-product-list-view .img-wrapper .product-img {
            width: 100%;
            height: 260px;
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
            background: #cf3f00;
            font-size: 14px;
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
            font-size: 20px;
            background: #cf3f00;
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
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/sidebar.css">
    <link rel="stylesheet" href="{{ asset('assets/front') }}/css/customize.css">
</head>

<body class="overflow-auto" style="overflow: auto !important;">

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
            <div class="d-flex align-items-center justify-content-between px-3 container-fluid">
                <div class="d-flex align-items-center gap-3 logo_Bar">
                    <div id="menu-btn" class="menu-icon active">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </div>
                    <img src="{{ asset('assets/assets/images/icons/logo.png') }}" class="logo" />
                </div>

                <div class="search-box d-none d-lg-block">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search for products (e.g. milk, rice, potato)" />
                </div>

                <button class="btn login-btn">Login</button>
            </div>
            <!-- Desktop Logo, Menubar, Search  End-->

            <!-- mobile search will appear below automatically -->
            <div class="search-box d-lg-none container">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search for products (e.g. milk, rice, potato)" />
            </div>
        </div>
    </header>

    <!-- Desktop Sidebar Start -->
    <aside id="sidebar" class="sidebar active pt-4 shadow">

        <!-- Offers Section -->
        <div class="offers-container">
            <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0">
                    Offers <span class="offer-outline-btn">17</span>
                </p>
            </a>
            <a href="#" class="d-flex gap-2 align-items-center mb-2 offers">
                <p class="pb-0 mb-0">Egg Club</p>
            </a>
        </div>

        <div class="ps-3">
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
        </div>

        <!-- MAIN ACCORDION -->
        <div class="accordion category-menu" id="accordionExample">

            <!-- Food -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#food" aria-expanded="false">
                        Food
                    </button>
                </h2>

                <div id="food" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                        <!-- Food Sub Accordion -->
                        <div class="accordion" id="foodSubAccordion">

                            <!-- Fruits -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#fruits">
                                        Fruits
                                    </button>
                                </h2>

                                <div id="fruits" class="accordion-collapse collapse"
                                    data-bs-parent="#foodSubAccordion">
                                    <div class="accordion-body">

                                        <!-- Sub accordion for Fruits -->
                                        <div class="accordion" id="fruitsSubAccordion">
                                            <ul>
                                                <li><a href="">Dry Food</a></li>
                                                <li><a href="">Fresh Fruits</a></li>
                                            </ul>

                                        </div>
                                        <!-- fruitsSubAccordion -->

                                    </div>
                                </div>
                            </div>
                            <!-- Fruits End -->

                            <!-- Vegetables -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#vegetables">
                                        Vegetables
                                    </button>
                                </h2>
                                <div id="vegetables" class="accordion-collapse collapse"
                                    data-bs-parent="#foodSubAccordion">
                                    <div class="accordion-body">
                                        Potatoes <br>
                                        Onions <br>
                                        Carrots <br>
                                        Spinach <br>
                                    </div>
                                </div>
                            </div>

                            <!-- Meat -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#meat">
                                        Meat
                                    </button>
                                </h2>
                                <div id="meat" class="accordion-collapse collapse"
                                    data-bs-parent="#foodSubAccordion">
                                    <div class="accordion-body">
                                        Beef <br>
                                        Chicken <br>
                                        Mutton <br>
                                    </div>
                                </div>
                            </div>

                            <!-- Fish -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#fish">
                                        Fish
                                    </button>
                                </h2>
                                <div id="fish" class="accordion-collapse collapse"
                                    data-bs-parent="#foodSubAccordion">
                                    <div class="accordion-body">
                                        Hilsa <br>
                                        Rohu <br>
                                        Catfish <br>
                                    </div>
                                </div>
                            </div>

                            <!-- Eggs -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#eggs">
                                        Eggs
                                    </button>
                                </h2>
                                <div id="eggs" class="accordion-collapse collapse"
                                    data-bs-parent="#foodSubAccordion">
                                    <div class="accordion-body">
                                        Chicken Eggs <br>
                                        Duck Eggs <br>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- foodSubAccordion -->

                    </div>
                </div>
            </div>

            <!-- Baby Food -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#baby">
                        Baby Food & Care
                    </button>
                </h2>
                <div id="baby" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Baby Formula & Cereal <br>
                        • Diapers & Wipes <br>
                        • Baby Lotion & Shampoo
                    </div>
                </div>
            </div>

            <!-- Home Cleaning -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#cleaning">
                        Home Cleaning
                    </button>
                </h2>
                <div id="cleaning" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Dish Wash & Floor Cleaner <br>
                        • Bathroom & Toilet Cleaner <br>
                        • Glass & Surface Cleaner
                    </div>
                </div>
            </div>

            <!-- Beauty & Health -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#beauty">
                        Beauty & Health
                    </button>
                </h2>
                <div id="beauty" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Skin Care & Face Wash <br>
                        • Hair Care & Shampoo <br>
                        • Medicine & Wellness Items
                    </div>
                </div>
            </div>

            <!-- Fashion -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#fashion">
                        Fashion & Lifestyle
                    </button>
                </h2>
                <div id="fashion" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Men's & Women's Clothing <br>
                        • Footwear & Bags <br>
                        • Accessories & Lifestyle Products
                    </div>
                </div>
            </div>

            <!-- Home & Kitchen -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#kitchen">
                        Home & Kitchen
                    </button>
                </h2>
                <div id="kitchen" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Kitchen Tools <br>
                        • Storage <br>
                        • Home Essentials
                    </div>
                </div>
            </div>

            <!-- Stationaries -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#stationaries">
                        Stationaries
                    </button>
                </h2>
                <div id="stationaries" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Office <br>
                        • Books <br>
                        • Pens
                    </div>
                </div>
            </div>

            <!-- Toys -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#toys">
                        Toys & Sports
                    </button>
                </h2>
                <div id="toys" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Kids Toys <br>
                        • Outdoor <br>
                        • Fitness Gadgets
                    </div>
                </div>
            </div>

            <!-- Gadgets -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#gadgets">
                        Gadgets
                    </button>
                </h2>
                <div id="gadgets" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Headphones <br>
                        • Smart Watches <br>
                        • Mobile Gadgets
                    </div>
                </div>
            </div>

            <!-- Grocery -->
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#grocery">
                        Grocery
                    </button>
                </h2>
                <div id="grocery" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        • Daily Essentials & Dry Foods <br>
                        • Beverages & Snacks <br>
                        • Household Grocery Items
                    </div>
                </div>
            </div>

        </div>
    </aside>
    <!-- Desktop Sidebar End -->


    <!-- Mobile Offcanvas Start-->
    <div id="mobile-offcanvas" class="mobile-offcanvas shadow">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Accordion Item #1
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        This is the first item's accordion body.
                    </div>
                </div>
            </div>
        </div>
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
            <div class="text-end position-fixed" style="right: 1%; top: 50%">

                <div class="cart-wrapper  anim" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                    aria-controls="offcanvasRight">
                    <div class="cart-top">
                        <img style="height: 21px; width: auto"
                            src="{{ asset('assets/assets/images/icons/bag.png ') }}" alt="" />
                        <p>10 ITEMS</p>
                    </div>

                    <div class="cart-bottom">
                        <p><span>৳</span> 1000</p>
                    </div>
                </div>

            </div>

            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel" class="mb-0 d-flex align-items-center">
                        <img style="height: 40px; width: auto"
                            src="{{ asset('assets/assets/images/icons/bag.png ') }}" alt="" />
                        <span class="cart-total-item">100 ITEMS</span>
                    </h5>

                    <button type="button" class="close-text-btn btn border-2 btn-outline-light"
                        data-bs-dismiss="offcanvas">
                        Close
                    </button>
                </div>
                <div class="offcanvas-body p-0">
                    <!-- Free Delivery info Message -->
                    <div class="alert py-1 px-0 my-0 alert-success rounded-0" role="alert">
                        <strong style="font-size: 12px; padding-left: 5px">Free Home Delivery on orders over
                            ৳1000!</strong>
                        <i class="fas fa-info-circle ms-2 d-inline-block"></i>
                    </div>
                    <!-- Super Express Delivery -->
                    <div style="background-color: #eee" class="p-1">
                        <img style="height: 30px; width: auto" src="./img/fast-delivery.png" alt="fast delivery" />
                        <strong style="font-size: 13px; margin-left: 8px">Super Express Delivery</strong>
                    </div>
                    <!-- Cart Items Start  -->
                    <div class="cart-item border-bottom">
                        <!-- Quantity -->
                        <div class="item-qty">
                            <button class="qty-btn">
                                <i class="fa-solid fa-chevron-up"></i>
                            </button>
                            <p>1</p>
                            <button class="qty-btn">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>

                        <!-- Product Image -->
                        <div class="item-img">
                            <img src="./img/eggs.webp" alt="" />
                        </div>

                        <!-- Title + Measure -->
                        <div class="item-info">
                            <h6>Chicken Eggs (Discounted)</h6>
                            <p class="item-measure">৳115 / 12 pcs</p>
                        </div>

                        <!-- Price -->
                        <div class="item-price">
                            <p class="old">৳125</p>
                            <p class="new">৳115</p>
                        </div>

                        <!-- Remove -->
                        <div class="item-remove">
                            <button><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                    <!-- Cart Items end -->
                    <!-- Cart Items Start  -->
                    <div class="cart-item border-bottom">
                        <!-- Quantity -->
                        <div class="item-qty">
                            <button class="qty-btn">
                                <i class="fa-solid fa-chevron-up"></i>
                            </button>
                            <p>1</p>
                            <button class="qty-btn">
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                        </div>

                        <!-- Product Image -->
                        <div class="item-img">
                            <img src="./img/eggs.webp" alt="" />
                        </div>

                        <!-- Title + Measure -->
                        <div class="item-info">
                            <h6>Chicken Eggs (Discounted)</h6>
                            <p class="item-measure">৳115 / 12 pcs</p>
                        </div>

                        <!-- Price -->
                        <div class="item-price">
                            <p class="old">৳125</p>
                            <p class="new">৳115</p>
                        </div>

                        <!-- Remove -->
                        <div class="item-remove">
                            <button><i class="fa-solid fa-xmark"></i></button>
                        </div>
                    </div>
                    <!-- Cart Items end -->
                    <!-- cart footer start -->
                    <button class="order-btn">
                        <span class="order-text">Place Order</span>
                        <span class="order-price">৳ 1,545</span>
                    </button>

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
    <script type="text/javascript">
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
    </script>
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
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        let typingTimer;
        const typingDelay = 300;

        searchInput.addEventListener('keyup', function() {
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
                                const productUrl = `{{ route('front.product', ':slug') }}`
                                    .replace(':slug', p.slug);

                                html += `
        <div class="search-item">
            <a href="${productUrl}">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('/assets/images/thumbnails') }}/${p.thumbnail}" alt="" style="width:40px;height:40px;margin-right:10px;">
                    <div>
                        <strong>${p.name}</strong><br>
                        <span>৳ ${parseFloat(p.price).toFixed(2)}</span>
                    </div>
                </div>
            </a>
        </div>
    `;
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

        // Hide results when clicked outside
        document.addEventListener('click', function(e) {
            if (!searchResults.contains(e.target) && e.target !== searchInput) {
                searchResults.style.display = 'none';
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selects = document.querySelectorAll('.measure-select');

            selects.forEach(select => {
                select.addEventListener('change', function() {
                    const measureType = this.dataset.measureType;
                    const selectedValue = parseFloat(this.value);
                    const priceElement = this.closest('.price-wrapper').querySelector(
                        '.product-price');
                    const basePrice = parseFloat(priceElement.dataset.basePrice);

                    let newPrice = basePrice;

                    // Custom calculation rules
                    if (measureType === 'KG' || measureType === 'LTR') {
                        // smaller quantity = divide
                        newPrice = basePrice * selectedValue;
                    } else if (measureType === 'PCS') {
                        // more pieces = multiply
                        newPrice = basePrice * selectedValue;
                    }

                    priceElement.textContent = newPrice.toFixed(2) + '৳';
                });
            });
        });
    </script>
    <!-- include bootstrap js cdn -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"
        integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            // ======================
            // MENU BUTTON TOGGLE
            // ======================
            $("#menu-btn").click(function() {
                if (window.innerWidth < 992) {
                    // Mobile Offcanvas
                    $("#mobile-offcanvas").toggleClass("active");
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

            // ======================
            // CATEGORY ACCORDION
            // ======================
            $(".cat-link").click(function(e) {
                e.preventDefault();

                let parent = $(this).parent();

                if (parent.hasClass("open")) {
                    return;
                }

                $(".cat-item").removeClass("open");
                $(".submenu").slideUp(200);

                parent.addClass("open");
                parent.find(".submenu").slideDown(200);
            });

        });
    </script>

</body>

</html>
