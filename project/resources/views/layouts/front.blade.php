<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        .header-logo-wrapper>img {
            width: 142px;
        }

        .single-product .content-wrapper,
        .single-product-list-view .content-wrapper {
            height: 140px;
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
    margin-bottom: 12px;
}
.cate-title{
    background: #ececec;
    height: 50px;
}
.single-product .img-wrapper, .single-product-list-view .img-wrapper {
    border: 1px solid #e5e5e5;
}
.single-product .img-wrapper .product-img, .single-product-list-view .img-wrapper .product-img {
    width: 100%;
    height: 230px;
}
    </style>

</head>

<body>

    @php
        $categories = App\Models\Category::with('subs')->where('status', 1)->get();
        $pages = App\Models\Page::get();
        $currencies = App\Models\Currency::all();
        $languges = App\Models\Language::all();
    @endphp
    <!-- header area -->
    @include('includes.frontend.header')

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

    @yield('content')


    <!-- footer section -->
    @include('includes.frontend.footer')
    <!-- footer section -->

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


    @yield('script')
    @stack('scripts')

</body>

</html>
