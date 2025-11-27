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
</body>

</html>
